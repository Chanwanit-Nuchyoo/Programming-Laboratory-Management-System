print(' *** Find Total lines ***')
filename = input("Enter file name : ")
f = open(filename)
line_count = 0
for l in f:
    line_count += 1
print(f'Total lines : {line_count}')
