car_dict = {'Volkswagan' : 1,
            'Toyota' : 2,
            'Tesla' : 2
}

data = input("Enter : ").split()

print('dict_old =',car_dict)

car_list = data[::2]
num_list = data[1::2]

for i in range(len(car_list)) :

    if car_list[i] in car_dict :

        print(car_list[i],'exists in dicts')
        car_dict[car_list[i]] += int(num_list[i])

    else :

        print(car_list[i],'does not exist')
        car_dict[car_list[i]] = int(num_list[i])

print('dict_new =',car_dict)