print(" *** Find 2 most numbers. ***")
text = input('Enter numbers : ')
max1_pos=0
max2_pos = 0
i=1
lst = text.split()
length = len(lst)
# find max1 position
while i<length:
    if int(lst[i]) > int(lst[max1_pos]):
        max1_pos = i
    i += 1
#print(f'max1={max1_pos} max2={max2_pos}')
# find max2 position
max2_pos = 0
if max1_pos == 0:
    max2_pos=1
i=1
while i<length:
    #print(f'i={i} max1={max1_pos} max2={max2_pos}')
    previous_max2 = max2_pos
    if int(lst[i]) > int(lst[max2_pos]):
        max2_pos = i
    if max2_pos == max1_pos:
        #print(f'i={i} max2={max2_pos} skip')
        i += 1
        max2_pos = previous_max2
        continue
    i += 1
    
print(f"Answer => {lst[max1_pos]} {lst[max2_pos]}")
#print(f'max1={max1_pos} max2={max2_pos}')