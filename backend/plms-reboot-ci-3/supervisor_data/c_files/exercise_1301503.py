print(' *** File Error Handling ***')
filename,word = input("Enter file name and word : ").split()
try:
    f = open(filename)
except:
    print(f"Error can not open file => {filename}")
    quit()
word_count = 0
line_count = 0
sum_line = 0
for l in f:
    line_count += 1
    if word in l:
        word_count += 1
        sum_line = sum_line + line_count
print(f'Number of lines having "{word}" => {word_count}')
print(f'Sum of line number => {sum_line}')
print(f'Total lines => {line_count}')