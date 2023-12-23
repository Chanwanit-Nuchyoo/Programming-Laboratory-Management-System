def f(num):
    sum = 0
    while num>0:
        sum += num%10
        num //= 10
    return sum
def parity(num):
    x = f(num)
    if x%2==0:
        return "EVEN"
    return "ODD"
    
print(" *** Sum and ODD/EVEN ***")
text = input("Enter a number : ")
num =  int(text)
print(f"Sum of each digits => {f(num)} => {parity(num)}")