def print_g(vertex,graph):
    i = 0
    print("   ","  ".join(map(str, vertex)))
    for e in graph:
        print(vertex[i],":",", ".join(map(str,e)))
        i+=1

data = input("Enter : ").split("/")
vertex = set()
ans_path = []
l = []
for e in data[0].split(","):
    a,w,b = e.split()
    vertex.add(a)
    vertex.add(b)
    l.append((a,b,int(w)))
for e in data[1].split(","):
    a,b = e.split()
    ans_path.append((a,b))

vertex = sorted(vertex)
vertex = list(vertex)
graph=[[0]*len(vertex) for i in range(len(vertex))]
for e in l:
    graph[vertex.index(e[0])][vertex.index(e[1])] = e[2]
    #print(e)
#print_g(vertex,graph)

def shortest_path(graph,vertex,start_v):
    known = [False]*len(vertex)
    path = dict()
    distance = [float('inf')]*len(vertex)
    distance[start_v] = 0
    while True:
        if not False in known:
            break
        v_min_dis = float('inf')
        v = None
        for i in range(len(vertex)):
            if known[i] == False:
                if distance[i] < v_min_dis:
                    v_min_dis = distance[i]
                    v = i
        if v==None:
            break
        
        known[v] = True
        for w in range(len(vertex)):
            if known[w]==False and graph[v][w] >= 1:
                if graph[v][w] + distance[v] < distance[w]:
                    distance[w] = graph[v][w] + distance[v]
                    path[vertex[w]] = vertex[v]
    return path

def print_p(l,end):
    if end not in l.keys():
        print(end,end="")
        return    
    print_p(l,l[end])
    print("->"+end,end="")
    
l_path = dict()
for e in ans_path:
    start_v = e[0]
    end_v = e[1]
    if start_v not in l_path.keys():
        if start_v in vertex and end_v in vertex:
            l_path[start_v] = shortest_path(graph,vertex,vertex.index(e[0]))
    if start_v not in l_path.keys() or end_v not in l_path[start_v]:
        print("Not have path :",start_v,"to",end_v)
    else:
        print(start_v,"to",end_v,": ",end="")
        print_p(l_path[start_v],end_v)
        if e != ans_path[-1]:
            print()
