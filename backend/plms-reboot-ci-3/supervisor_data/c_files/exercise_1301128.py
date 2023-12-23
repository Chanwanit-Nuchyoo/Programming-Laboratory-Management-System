class Students:
    def __init__(self, FirstName="", LastName=""):
        self.FirstName = FirstName
        self.LastName = LastName

    def EnterFirstName(self, FirstName):
        self.FirstName = FirstName
    
    def EnterLastName(self, LastName):
        self.LastName = LastName

    def EnterFullName(self, FirstName, LastName):
        self.FirstName = FirstName
        self.LastName = LastName

    def getFirstName(self):
        if self.FirstName == "":
            return "Please Enter Your Firstname"
        return self.FirstName.capitalize()

    def getLastName(self):
        if self.LastName == "":
            return "Please Enter Your Lastname"
        return self.LastName.capitalize()

    def getFullName(self):
        if (self.FirstName == "") and (self.LastName == ""):
            return "Please Enter Your Firstname & Lastname"
        elif self.FirstName == "":
            return "Please Enter Your Firstname"
        elif self.LastName == "":
            return "Please Enter Your Lastname"
        return "{0} {1}".format(self.FirstName.capitalize(), self.LastName.capitalize())

    def Email(self):
        if (self.FirstName == "") and (self.LastName == ""):
            return "Please Enter Your Firstname & Lastname"
        elif self.FirstName == "":
            return "Please Enter Your Firstname"
        elif self.LastName == "":
            return "Please Enter Your Lastname"
        return "{0}.{1}@kmitl.ac.th".format(self.FirstName.lower(), self.LastName.lower())

print("*** Create Email < BY KMITL > ***")
student = Students()
S = input("Enter Input : ").split(',')
for s in S:
    if (s[0] not in ["E", "F", "L", "A", "X"]) and (s[0:2] not in ["SF", "SL", "SA"]):
        print("\'{0}\' is Invalid Input !!!".format(s))
        break
    if s[0] == "E":
        print("\'{0}\' -> Email : {1}".format(s,student.Email()))
    elif s[0] == "F":
        student.EnterFirstName(s.split()[1])
    elif s[0] == "L":
        student.EnterLastName(s.split()[1])
    elif s[0] == "A":
        #k = s.split()
        student.EnterFullName(s.split()[1], s.split()[2])
    elif s[0:2] == "SF":
        print("\'{0}\' -> Firstname : {1}".format(s,student.getFirstName()))
    elif s[0:2] == "SL":
        print("\'{0}\' -> Lastname : {1}".format(s,student.getLastName()))
    elif s[0:2] == "SA":
        print("\'{0}\' -> Fullname : {1}".format(s,student.getFullName()))
    elif s[0] == "X":
        break