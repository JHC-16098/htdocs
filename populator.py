import random
global users
global scramble
users = ['0', '1', '2', '3', '4', '5', '6' '7', '8', '9']
scramble = ["R' F' U2 D' R D' F' R U' B2 D L2 F2 D' R2 U2 B2 R2 L2 U", "L2 B' U2 R' D2 L D2 R' B2 R' B2 R2 F2 R' D' U' R F' L' R2 U", "L2 U2 R2 F2 L2 F' U2 B' L2 U2 B D2 R' F2 L D R' F2 D R", "R2 F2 D R2 B2 U B2 D' B2 F2 U R' D F R2 D' L2 B F"]
global id
id = 211

def write_line():
    global id
    f = open("data.csv", "a")
    date = (str(random.randint(1990, 2021)) + "-" + str(random.randint(0, 12)).rjust(2, "0") + "-" + str(random.randint(0, 30)).rjust(2, "0") + " " + str(random.randint(0, 24)).rjust(2, "0") + ":" + str(random.randint(0, 60)).rjust(2, "0") + ":00")
    stime = (str(random.randint(0, 60)).rjust(2, "0") +"."+str(random.randint(0, 99)).rjust(2, "0"))
    userindex = random.randint(0, 8)
    print(userindex)
    scrambleindex = random.randint(0,2)
    print(scrambleindex)

    stringToWrite = (str(id) + "," + users[userindex] +","+stime+",,"+scramble[scrambleindex]+","+date+","+stime+"\n")
    f.write(stringToWrite)
    f.close()
    id = id + 1
    

for i in range(1000):
    write_line()

