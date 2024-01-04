# ================== Injected code ==================
import builtins

def custom_input(user_inputs, prompt=""):
    if not user_inputs:
        raise EOFError("Ran out of input values.")
    response = user_inputs.pop(0)
    print(prompt + response)
    return response

with open('supervisor_data/c_files/exercise_temp_1301408.py.input', 'r') as file:
    user_inputs = file.read().splitlines()

builtins.input = lambda prompt="": custom_input(user_inputs, prompt)

# ================== Actual sourcecode content ================== 

n = int(input("Sum from 1 to : "))
if n <= 0 :
    print("Input Error")
    quit()
i = 1
sum = 0
while i <= n :
    sum = sum + i
    i = i + 1
print("Sum from 1 to", n,"is",sum)