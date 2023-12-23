print(' *** Find Empty lines ***')
filename = input("Enter file name : ")
f = open(filename)
empty_line_count = 0
line_count = 0
for l in f:
    line_count += 1
    if len(l) <= 1:
	    empty_line_count += 1
print(f'Empty lines => {empty_line_count}')
print(f'Total lines => {line_count}')