car_dict = {'Tesla'  : 10,
            'Ford'   : 50,
            'Toyota' : 20,
            'Honda'  : 80
}

data = input("Enter : ").split()

print('dict_old =',car_dict)

car_list = data[::2]
num_list = data[1::2]

for i in range(len(car_list)) :

    if car_list[i] in car_dict :

        print(car_list[i],'exists in dicts')
        car_dict[car_list[i]] -= int(num_list[i])

        print('dict_new =',car_dict)

    else :

        print(car_list[i],'does not exist')