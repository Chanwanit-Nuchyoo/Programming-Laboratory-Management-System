class Stack :
    def __init__(self,list = None) :
        if list == None :
            self.item = []
        else :
            self.item = list()

    def isEmpty(self) :
        return self.item == []
    
    def push(self,data) :
        return self.item.append(data)
        
    def pop(self) :
        if not self.isEmpty() :
            return self.item.pop()
        
    def size(self) :
        return len(self.item)

    def peek(self) :
        return self.item[-1]


def infixtopostfix(infixexpr):

    s=Stack()
    outlst=[]
    priorty={}
    priorty['^']=4
    priorty['/']=3
    priorty['*']=3
    priorty['+']=2
    priorty['-']=2
    priorty['(']=1


    tokenlst=' '.join(infixexpr).split()
    for token in tokenlst:
        if token in 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' or token in '0123456789':
            outlst.append(token)

        elif token == '(':
            s.push(token)

        elif token == ')':
            topToken=s.pop()
            while topToken != '(':
                outlst.append(topToken)
                topToken=s.pop()
                
        elif token == '^' :
            s.push(token)
            
        else:
            while (not s.isEmpty()) and (priorty[s.peek()] >= priorty[token]):
                #print token
                outlst.append(s.pop())
                #print outlst

            s.push(token)
            #print (s.peek())

    while not s.isEmpty():
        opToken=s.pop()
        outlst.append(opToken)
        #print outlst
    #return outlst
    return " ".join(outlst)



def infix2postfix(exp) :
    s = Stack()
    postfix = []
    listoperation = ['+','-','*','/','%','(',')']
    outstack =      [ 2,  2,  4,  4,  4,  8,  1 ]
    instack =       [ 2,  2,  4,  4,  4,  0     ]

    tokenlst=' '.join(exp).split()

 
    
    for token in tokenlst:   
        if token not in listoperation :
                postfix.append(token)
        else :
            p = outstack[listoperation.index(token)]
            while not s.isEmpty() and instack[listoperation.index(s.peek())] >= p :
                postfix.append(s.pop())
            if token == ')' :
                s.pop()
            else :
                s.push(token)
    while not s.isEmpty() :
        postfix.append(s.pop())

    s = ''
    return s.join(postfix)
        

print(" ***Infix to Postfix***")
token = input("Enter Infix expression : ")
print("PostFix : ")
print(infix2postfix(token))