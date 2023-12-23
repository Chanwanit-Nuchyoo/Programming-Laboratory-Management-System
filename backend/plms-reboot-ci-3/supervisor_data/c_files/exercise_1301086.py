def odd_list(al):
    ans = []
    for ele in al:
        if int(ele) % 2 != 0:
            ans.append(int(ele))
    return ans


print(" ***Function Odd List***")
ls = [int(e) for e in input("Enter list numbers : ").split()]
# print(ls)
opls = odd_list(ls)
print("Input list : ", ls, "\nOutput list : ", opls)