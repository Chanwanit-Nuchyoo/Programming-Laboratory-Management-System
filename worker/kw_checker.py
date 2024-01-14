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


def check_constraints(user_kw_list, kw_list):
    for category, con_list in kw_list.items():
        for con in con_list:
            # Find the corresponding item in user_kw_list[category]
            user_kw = next(
                (
                    item
                    for item in user_kw_list[category]
                    if item["keyword"] == con["keyword"]
                ),
                None,
            )
            if user_kw is not None:
                if con["type"] == "eq" and user_kw["limit"] != con["limit"]:
                    return False
                elif con["type"] == "me" and user_kw["limit"] < con["limit"]:
                    return False
                elif con["type"] == "le" and user_kw["limit"] > con["limit"]:
                    return False
                elif con["type"] == "na" and user_kw["limit"] > 0:
                    return False
    return True


def main():
    if len(sys.argv) < 3:
        print("Usage: python3 kw_checker.py <script_to_run.py> <keyword.json>")
        return

    # get the filename from the arguments
    file_path = sys.argv[1]
    kw_list_path = sys.argv[2]

    if file_path is None:
        raise Exception("No file path provided")

    if kw_list_path is None:
        raise Exception("No keyword list provided")

    try:
        with open(kw_list_path, "r") as f:
            kw_list = json.load(f)
    except IOError as e:
        print(f"Error opening file: {e}")
        return

    try:
        with open(file_path, "r") as f:
            code = f.read()
    except IOError as e:
        print(f"Error opening file: {e}")
        return

    analysis_result = analyze_code(code)

    if analysis_result["status"] == "error":
        print(f"Error analyzing code: {analysis_result['message']}")
        return

    user_kw_list = analysis_result["data"]

    if check_constraints(user_kw_list, kw_list):
        print("true")
    else:
        print("false")


if __name__ == "__main__":
    main()
