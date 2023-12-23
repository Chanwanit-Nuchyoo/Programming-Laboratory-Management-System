def asteroid_collision(asts):
    if len(asts) < 2:
        return asts
    if asts[0] < 0:
        return [asts[0]] + asteroid_collision(asts[1:])
    else:
        meh = asteroid_collision(asts[1:])
        if len(meh) == 0:
            return [asts[0]]
        if meh[0] > 0:
            return [asts[0]] + meh
        if asts[0]+meh[0] < 0:
            return meh
        if asts[0]+meh[0] == 0:
            return meh[1:]
        if asts[0]+meh[0] > 0:
            return asteroid_collision([asts[0]]+meh[1:])

x = input("Enter Input : ").split(",")
x = list(map(int,x))
print(asteroid_collision(x))

