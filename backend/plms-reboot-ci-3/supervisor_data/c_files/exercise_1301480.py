word1, word2 = input("Enter : ").split()

count1_total = {}
for char in word1 :

    count1_total[char] = count1_total.get(char,0) + 1

count2_total = {}
for char in word2 :

    count2_total[char] = count2_total.get(char,0) + 1

print('dict1 =',count1_total)
print('dict2 =',count2_total)
print('Dictionaries comparison:')

check = 0
for k in count1_total.keys():

    if k in count2_total :

        if count1_total[k] == count2_total[k] : 

            check = 1
            print(k,count1_total[k])

if check == 0:
    print('None')