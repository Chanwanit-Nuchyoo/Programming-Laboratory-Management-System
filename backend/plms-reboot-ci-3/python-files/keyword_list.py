import json
import tokenize
from io import BytesIO
import keyword
import sys


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


def check_error(code_str):
    try:
        compile(code_str, "<string>", "exec")
        return None  # No syntax error found
    except Exception as e:
        return str(e)  # Return the syntax error message


def analyze_code(code_str):
    error = check_error(code_str)
    if error:
        return {
            "status": "error",
            "message": error,
            "data": None,
        }
    else:
        suggested_constraints = keyword_analyzer(code_str)
        return {
            "status": "success",
            "message": "Analysis completed successfully.",
            "data": suggested_constraints,
        }


if __name__ == "__main__":
    # get the filename from the arguments
    file_path = sys.argv[1]

    if file_path == None:
        raise Exception("No file path provided")

    try:
        with open(file_path, "r") as f:
            code = f.read()
    except IOError as e:
        print(f"Error opening file: {e}")
        sys.exit(1)

    result = analyze_code(code)

    print(json.dumps(result, indent=2, sort_keys=False))
