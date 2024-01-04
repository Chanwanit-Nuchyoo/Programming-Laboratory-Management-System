# ================== Injected code ==================
import builtins

def custom_input(user_inputs, prompt=""):
    if not user_inputs:
        raise EOFError("Ran out of input values.")
    response = user_inputs.pop(0)
    print(prompt + response)
    return response

with open('supervisor_data/c_files/exercise_temp_1301646.py.input', 'r') as file:
    user_inputs = file.read().splitlines()

builtins.input = lambda prompt="": custom_input(user_inputs, prompt)

# ================== Actual sourcecode content ================== 

a = float(input("Enter a: "))
b = float(input("Enter b: "))

print("a/b =", a/b)