def draw_pyramid(height):
    for i in range(height):
        for j in range(height - i):
            if (j == (height - i - 1)): print("/", end="")
            else: print(" ",end="")
        for k in range(i * 2):
            if (i == height - 1): print("_", end="")
            else: print(".", end="")
        for l in range(height - i):
            if (l == 0): print("\\",end="")
            else: print(" ", end="")
        print()

print(" *** Pyramid-V ***")
inp = int(input("Enter height : "))
draw_pyramid(inp)
print("===== End of program =====")
