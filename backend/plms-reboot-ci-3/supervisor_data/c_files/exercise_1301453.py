# starting shopping list, don't delete
shopping_lst = ["egg", "ham", "water", "soda"]

print("*** Shopping List ***")
# <a/r> <itemname>,<a/r> <itemname>,...
raw_input = input("Enter some pairs of (operation, item): ").split(",")
for pair in raw_input:
    op, item = pair.split()
    item = item.lower()
    if op == "a":
        if shopping_lst.count(item) <= 0:
            shopping_lst.append(item)
    elif op == "r":
        if shopping_lst.count(item) > 0:
            shopping_lst.remove(item)
    else:
        print('Operation not supported!')
        quit()
print('Final shopping list is', shopping_lst)
