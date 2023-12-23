def divisiblenumber():
  print(" *** Divisible number ***");
  num = int(input("Enter a positive number : "))
  count = 0
  if num < 1 :
    print(f"{num} is OUT of range !!!")
    return 0
  print("Output ==> ",end='')
  for a in range(1,num+1): 
    if num % a == 0 :
      print(f"{a} ",end='')
      count += 1
  print(f"\nTotal ==> {count}\n")


divisiblenumber()