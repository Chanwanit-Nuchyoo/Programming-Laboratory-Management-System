
graph = {'A':{'B':1,'C':2}, 'B':{'D':12,'A':1}, 'C':{'D':9,'F':3,'A':2}, 'D':{'C':9,'E':7,'G':1},\
         'E':{'G':5,'D':7}, 'F':{'G':4}, 'G':{'D':1,'E':5,'F':4}}

def dijkstra(graph,start,goal):
    shortest_distance = {}
    predecessor = {}
    unseenNodes = graph
    infinity = 9999999
    path = []
    for node in unseenNodes:
        shortest_distance[node] = infinity
    shortest_distance[start] = 0

    while unseenNodes:
        minNode = None
        for node in unseenNodes:
            if minNode is None:
                minNode = node
            elif shortest_distance[node] < shortest_distance[minNode]:
                minNode = node

        for childNode, weight in graph[minNode].items():
            if weight + shortest_distance[minNode] < shortest_distance[childNode]:
                shortest_distance[childNode] = weight + shortest_distance[minNode]
                predecessor[childNode] = minNode
        unseenNodes.pop(minNode)

    currentNode = goal
    while currentNode != start:
        try:
            path.insert(0,currentNode)
            currentNode = predecessor[currentNode]
        except KeyError:
            print('Path not reachable')
            break
    path.insert(0,start)
    if shortest_distance[goal] != infinity:
        print('Shortest distance is ' + str(shortest_distance[goal]))
        print('And the path is ' + str(path))


print(""" *** Dijkstra's shortest path ***""")
input_string = input("Enter start and target vertex : ")
start,target = input_string.split()
dijkstra(graph,start,target)