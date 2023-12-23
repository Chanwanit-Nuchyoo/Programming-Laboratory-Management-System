# Function to rotate string left and right by d length 
  
def leftRotate(input,d): 
  
    # slice string in two parts for left and right 
    Lfirst = input[0 : d] 
    Lsecond = input[d :] 
    Rfirst = input[0 : len(input)-d] 
    Rsecond = input[len(input)-d : ] 
    return (Lsecond + Lfirst)
  

def rightRotate(input,d): 
  
    # slice string in two parts for left and right 
    Lfirst = input[0 : d] 
    Lsecond = input[d :] 
    Rfirst = input[0 : len(input)-d] 
    Rsecond = input[len(input)-d : ] 
    return (Rsecond + Rfirst)


# Driver program 

if __name__ == "__main__": 
    print("*** String Rotation ***")
    s1, s2 = input("Enter 2 strings : ").split()
    count = 0
    s1a = s1
    s2a = s2
    while (True):
        count += 1
        s1a = rightRotate(s1a,2)
        s2a = leftRotate(s2a,3)
        if (count<=5):
            print(count,s1a,s2a)       
        if(s1==s1a and s2==s2a):
            break;

    if (count==6):
        print(count,s1a,s2a)    
    elif(count>=5):
        print(" . . . . . ") 
        print(count,s1a,s2a) 
    print("Total of ",count,"rounds.")
