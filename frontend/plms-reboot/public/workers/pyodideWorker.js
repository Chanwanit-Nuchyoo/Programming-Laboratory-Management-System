self.importScripts('../pyodide/pyodide.js');

async function initializePyodide() {
    try {
        if (typeof self.loadPyodide === 'function') {
            self.pyodide = await self.loadPyodide();
            self.postMessage({ status: 'initialized', message: "Pyodide is initialized", result: null });
        } else {
            throw new Error('loadPyodide function is not available.');
        }
    } catch (error) {
        self.postMessage({ status: 'error', message: 'Failed to initialize Pyodide.', result: null });
    }
}

initializePyodide();

self.onmessage = (event) => {
    if (!self.pyodide) {
        self.postMessage({ status: 'error', message: 'Pyodide is not initialized.', result: null });
        return;
    }

    const { pythonCode } = event.data;

    let response;
    try {
        // Set up StringIO and redirect stdout
        self.pyodide.runPython(`
import sys
import io
stdout_backup = sys.stdout
sys.stdout = io.StringIO()
    `);

        // Execute the user's code
        self.pyodide.runPython(`
import json
import tokenize
from io import BytesIO
import keyword


def keyword_analyzer(code_str):
    tokens = list(tokenize.tokenize(BytesIO(code_str.encode("utf-8")).readline))

    reserved_keywords = set(keyword.kwlist)

    suggested_constraints = {
        "reserved_words": {},
        "functions": {},
        "methods": {},
        "variables": {},
        "imports": {},
        "classes": {},
    }

    num_tokens = len(tokens)
    i = 0

    while i < num_tokens:
        token = tokens[i]
        if token.type == tokenize.NAME:
            name = token.string
            category = None

            if name in reserved_keywords:
                category = "reserved_words"
            elif i > 0 and tokens[i - 1].string == "import":
                category = "imports"
            elif name in suggested_constraints["imports"]:
                category = "imports"
            elif (
                i + 2 < num_tokens
                and tokens[i - 1].string == "."
                and tokens[i + 1].string == "("
            ):
                # Method
                category = "methods"
            elif (
                i + 2 < num_tokens
                and tokens[i + 1].string == "("
                and tokens[i + 2].string == "self"
            ):
                # Method in class
                category = "methods"
            elif i + 1 < num_tokens and tokens[i + 1].string == "(":
                if name[0].islower():
                    # Function
                    category = "functions"
                else:
                    # Class
                    category = "classes"
            elif i > 0 and tokens[i - 1].string == "class" and name[0].isupper():
                # Class
                category = "classes"
            else:
                # Variable
                category = "variables"

            suggested_constraints[category][name] = (
                suggested_constraints[category].get(name, 0) + 1
            )

        i += 1

    # Transform the dictionary into the desired shape
    transformed_constraints = {
        category: [
            {"keyword": keyword, "limit": limit} for keyword, limit in keywords.items()
        ]
        for category, keywords in suggested_constraints.items()
    }

    return transformed_constraints


def check_syntax(code_str):
    try:
        compile(code_str, "<string>", "exec")
        return None  # No syntax error found
    except SyntaxError as e:
        return str(e)  # Return the syntax error message


def analyze_code(code_str):
    syntax_error = check_syntax(code_str)
    if syntax_error:
        return {
            "status": "error",
            "message": f"Syntax Error: {syntax_error}",
            "data": None,
        }
    else:
        suggested_constraints = keyword_analyzer(code_str)
        return {
            "status": "success",
            "message": "Analysis completed successfully.",
            "data": suggested_constraints,
        }
    `);

        // self.pyodide.runPython(pythonCode);
        self.pyodide.runPython(`
result = analyze_code(${pythonCode})
print(json.dumps(result, indent=2, sort_keys=False))
    `)

        // Capture and reset stdout
        const output = self.pyodide.runPython(`
output = sys.stdout.getvalue()
sys.stdout = stdout_backup
output
    `);

        response = { ...JSON.parse(output) };
    } catch (error) {
        response = { status: 'error', message: error.message, result: null };
    }

    self.postMessage(response);
};
