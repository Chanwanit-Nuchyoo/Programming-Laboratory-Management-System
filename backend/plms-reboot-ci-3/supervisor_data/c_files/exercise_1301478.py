words = input("Enter : ")
words_list = words.split()

count_total = {}
for word in words_list :

    count = {}
    for char in word :
        count[char] = count.get(char,0) + 1
        count_total[char] = count_total.get(char,0) + 1

    if len(words_list) > 1:
        print(word,'=',count)

print(words,'=',count_total)

k_max = ''
v_max = 0
for k, v in count_total.items():

    if v > v_max :
        v_max = v
        k_max = k

print('Maximum Character Count:',k_max,v_max)
