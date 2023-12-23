# Verify that the number is within the specified range.
def is_in_range(rmin,rmax,num1):
    if rmin == rmax:
        print("\nThe specified range is invalid!")
        quit()
    if rmin <= num1 <= rmax:   
        return True
    else:
        return False

print("*** Verify that the number is within the specified range. ***")
nums = input('Enter range and number <min max num>: ')
nmin,nmax,num = nums.split()
nmin,nmax,num = int(nmin),int(nmax),int(num)
if nmin > nmax:
        nmin,nmax = nmax,nmin
if is_in_range(nmin,nmax,num):
    print("\nYes, number '%d' is in the range [%d %d]." %(num,nmin,nmax))
else:
    print("\nNo, the number '%d' is out of range [%d %d]." %(num,nmin,nmax))
