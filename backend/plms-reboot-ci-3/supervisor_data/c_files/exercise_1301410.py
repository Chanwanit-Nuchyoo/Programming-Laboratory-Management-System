def find_min(lst):
    min_value = float('inf')
    for value in lst:  # implement this loop
        value = float(value)
        if value < min_value:
            min_value = value
    if min_value== int(min_value):
        return int(min_value)
    return min_value

print(" *** Minimum value ***")
lst = input("Enter some numbers: ").split()
print("Min value =",find_min(lst))
