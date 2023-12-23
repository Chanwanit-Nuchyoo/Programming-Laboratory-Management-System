def find_max(lst):
    max_value = -1*float('inf')
    for value in lst:  # implement this loop
        value = float(value)
        if value > max_value:
            max_value = value
    if max_value== int(max_value):
        return int(max_value)
    return max_value

print(" *** Maximum value ***")
lst = input("Enter some numbers: ").split()
print("Max value =",find_max(lst))