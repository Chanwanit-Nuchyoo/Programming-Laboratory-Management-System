def butterfly():
  num = input("Input : ")
  num = int(num)
  if num > 0:
    for row in range(num+1):
        for i in range(row):
            print("*", end="")
        for i in range(2*(num-row)):
            print(" ", end="")
        for i in range(row):
            print("*", end="")
        print()
    for row in reversed(range(num)):
        for i in range(row):
            print("*", end="")
        for i in range(2*(num-row)):
            print(" ", end="")
        for i in range(row):
            print("*", end="")
        print()
  else:
      print("!!!Please enter number greater than zero!!!")

butterfly()