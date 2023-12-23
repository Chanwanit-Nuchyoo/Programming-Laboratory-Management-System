def print_g(vertex,graph):
    i = 0
    print("   ","  ".join(map(str, vertex)))
    for e in graph:
        print(vertex[i],":",", ".join(map(str,e)))
        i+=1

data = input("Enter : ").split(",")
vertex = set()
l = []
for e in data:
    a,b = e.split()
    vertex.add(a)
    vertex.add(b)
    l.append((a,b))

vertex = sorted(vertex)
vertex = list(vertex)
graph=[[0]*len(vertex) for i in range(len(vertex))]
for e in l:
    graph[vertex.index(e[0])][vertex.index(e[1])] = 1
    #print(e)
print_g(vertex,graph)