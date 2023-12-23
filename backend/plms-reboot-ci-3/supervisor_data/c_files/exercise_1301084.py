def windClass():

    print(" *** Wind classification ***")
    windspeed = float(input("Enter wind speed (km/h) : "))
#    print(windspeed)
    print("Wind classification is ", end="")
    if windspeed > 0:
        if windspeed < 52: print("Breeze.")
        elif windspeed < 56: print("Depression.")
        elif windspeed < 102: print("Tropical Storm.")
        elif windspeed < 209: print("Typhoon.")
        else: print("Super Typhoon.")
    else:
        print("NOT in range -->", windspeed)

windClass()