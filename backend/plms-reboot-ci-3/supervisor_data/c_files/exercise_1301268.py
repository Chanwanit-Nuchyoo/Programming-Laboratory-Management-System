def print_g(vertex,graph):
    i = 0
    print("   ","  ".join(map(str, vertex)))
    for e in graph:
        print(vertex[i],":",", ".join(map(str,e)))
        i+=1
def traverse(v,visited,vertex,graph):
    print("",vertex[v],end="")
    visited[v] = True
    for i in range(len(vertex)):
        if graph[v][i] == 1 and visited[i]==False:
            traverse(i,visited,vertex,graph)

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
    graph[vertex.index(e[1])][vertex.index(e[0])] = 1
#print_g(vertex,graph)
print("Depth First Traversals :",end="")
visited = [False]*len(vertex)
while False in visited:
    v = visited.index(False)
    traverse(v,visited,vertex,graph)

print("\nBredth First Traversals :",end="")
visited = [False]*len(vertex)
q = []
for e in vertex:
    if False in visited and visited[vertex.index(e)]==False:
        q.append(vertex.index(e))
        while q != []:
            v = q.pop(0)
            if visited[v] == False:
                visited[v] = True
                print("",vertex[v],end="")
                for i in range(len(vertex)):
                    if graph[v][i] == 1 and visited[i]==False:
                        q.append(i)
    elif False not in visited:
        break

    
