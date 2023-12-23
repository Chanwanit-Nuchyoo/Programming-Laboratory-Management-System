words_list = input("Enter : ").split()

words_new = ''
count_total = {}
for word in words_list :

    for char in word :

        count_total[char] = count_total.get(char,0) + 1

    words_new += word + ' '

    print(words_new,end='')
    print('=',count_total)

k_max = ''
v_max = 0
for k, v in count_total.items():

    if v > v_max :
        v_max = v
        k_max = k

print('Maximum Character Count:',k_max,v_max)