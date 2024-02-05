# runner.py
import builtins
import sys


def custom_input(user_inputs, prompt=""):
    if not user_inputs:
        raise EOFError("Ran out of input values.")
    response = user_inputs.pop(0)
    print(prompt + response)
    return response


def main():
    # Check command line arguments
    if len(sys.argv) < 2:
        raise ValueError("Usage: python3 runner.py <script_to_run.py> [<input_file>]")

    script_to_run = sys.argv[1]
    user_inputs = []  # Initialize user_inputs as an empty list

    # If an input file is provided
    if len(sys.argv) > 2:
        input_file = sys.argv[2]

        # Read inputs from the input file
        with open(input_file, "r") as file:
            user_inputs = file.read().splitlines()

    # Override the built-in input function
    builtins.input = lambda prompt="": custom_input(user_inputs, prompt)

    # Run the script
    with open(script_to_run) as file:
        exec(file.read(), {})


if __name__ == "__main__":
    main()
