print("*** Minesweeper ***")
def num_grid(lst):
    for i in range(len(lst)):
        for j in range(len(lst[i])):
            if lst[i][j] == '-':
                x = 0
                for u in range(i-1,i+2):
                    for v in range(j-1,j+2):
                        if 0 <= v < len(lst[i]) and 0 <= u < len(lst) and lst[u][v] == '#':
                            x+=1
                lst[i][j] = str(x)
    return lst

lst_input = []
input_list = input("Enter input(5x5) : ").split(",")
for e in input_list:
 	lst_input.append([x for x in e.split()])
print("\n",*lst_input,sep = "\n")
print("\n",*num_grid(lst_input),sep = "\n")