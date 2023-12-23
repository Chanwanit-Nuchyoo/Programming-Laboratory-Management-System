# Source code
def bubble_sort(list2):
    # swap_test = False
    for i in range(0, len(list2) - 1):
        # as suggested by kubrick, makes sense
        swap_test = False
        for j in range(0, len(list2) - i - 1):
            if list2[j] > list2[j + 1]:
                list2[j], list2[j + 1] = list2[j + 1], list2[j]  # swap
            swap_test = True
        if swap_test == False:
            break

input_list = [ int(x) for x in input("Enter number list: ").split(" ")]

bubble_sort(input_list)

print(input_list)