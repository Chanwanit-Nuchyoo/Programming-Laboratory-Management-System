# starting shopping list, don't delete
shopping_dict = {
    "egg": 1,
    "ham": 1,
    "water": 1,
    "soda": 1,
}

print("*** Shopping List 2 ***")
# <a/r> <itemname>,<a/r> <itemname>,...
raw_input = input("Enter some pairs of (operation, item): ").split(",")


for pair in raw_input:
    op, item = pair.split()
    item = item.lower()
    if op == "a":
        shopping_dict[item] = 1 + shopping_dict.get(item, 0)
    elif op == "r":
        if shopping_dict.get(item, -1) != -1:  # item exist
            shopping_dict[item] -= 1
            if shopping_dict.get(item) <= 0:  # if reached 0, delete item from list
                shopping_dict.pop(item)
    else:
        print('Operation not supported!')
        quit()


print('Final shopping dict is', shopping_dict)
