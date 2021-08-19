import pymysql
import xlrd
import sys
import re
import json
mapper = {
    #"#": 1,
    "timestamp": 1,
    "fno_col": 2,
    "floor_col": 3,
    "block_col": 4,
    "host": 5,
    "file_location": 6, 
    "username_db": 7,
    "password_db": 8,
    "dbname": 9,       
    "upload_constraint": 10,
    "login_role": 11,
}

header = []
header_id = {}
end_col = 7
startcol_index = 2
passw = ""
file = xlrd.open_workbook(sys.argv[mapper['file_location']])
data = file.sheet_by_index(0)
for y in range(0, data.ncols):
    header.append(data.cell(0, y).value)
# print(header)
if len(sys.argv) != 12:
    #print("len",len(sys.argv))
    end_col = 6
else: 
    passw = sys.argv[mapper['password_db']]
    #print("p",passw)
try:
    #print(len(sys.argv)-end_col)
    for x in range(startcol_index, len(sys.argv)-end_col):
        #print("x:",sys.argv[x])
        header_id[sys.argv[x]] = header.index(sys.argv[x])


except Exception as e:
    # print("ex occured!")
    print(re.findall(r"'(.*?)'", str(e),)
          [0]+" is not a column in the uploaded sheet")
    sys.exit(0)

# print("hi")
insert_flat = """ Insert into flats(FlatID, FlatNumber, BlockNumber, Floor , FlatAreaID, created_at , updated_at) VALUES('',%s,%s,%s,%s,%s,%s); """
update_flat = "update flats set FlatNumber=%s,BlockNumber=%s,Floor=%s,FlatAreaID=%s,created_at=%s,updated_by=%s where BlockNumber=%s and FlatNumber=%s"
flat_area_id = "select FlatAreaID from flatarea where BlockNumber=%s and FlatSeries=%s"
#

# print(sys.argv[mapper['dbname']])
# print("hi")
connection = pymysql.connect(host=sys.argv[mapper['host']],
                             user=sys.argv[mapper['username_db']],
                             passwd=passw,
                             database=sys.argv[mapper['dbname']])
# print("hi conn established!")
cursor = connection.cursor()
# print(cursor)
timestamp = sys.argv[mapper['timestamp']]
#added = sys.argv[mapper['#']]
upload_constraint = sys.argv[mapper['upload_constraint']]
#print("c",upload_constraint)
login_role = sys.argv[mapper['login_role']]
#print("hi")
password_set = 0
inserted_records_count = 0
updated_records_count = 0

def insert_record(update_values, values_insert):
    global updated_records_count, inserted_records_count
    # operation_performed = ""
    # status = ""

    if sys.argv[mapper['upload_constraint']] == "2":
        # operation_performed = "UPDATE"
        # status = "updated details " 
        updated_records_count += cursor.execute(update_flat, update_values)
        
    else:
        # operation_performed = "INSERT"
        # status = "Area record inserted"
        cursor.execute(insert_flat, values_insert)
        inserted_records_count += 1        

try:
    #print("inside try")
    # print(data.nrows)
    for x in range(1, data.nrows):
        #print("in for loop")
        #print(x)
        #print(data.cell(x, header_id[sys.argv[mapper['block_col']]]).value)
        blockno = data.cell(x, header_id[sys.argv[mapper['block_col']]]).value
        #print("b",blockno)
        flatno = data.cell(x, header_id[sys.argv[mapper['fno_col']]]).value
        #flatno = str(int(flatno)).zfill(2)
        # print(flatno)
        floor = data.cell(x, header_id[sys.argv[mapper['floor_col']]]).value
        flatseries = flatno - (100*floor)
        flatseries = int(flatseries)
        #print("series",flatseries)
        val = (str(blockno),flatseries)
        #print(val)
        cursor.execute(flat_area_id, val) 
        flatareaid_tuple = cursor.fetchone()
        #for i in flatareaid_tuple:
        #   flatareaid = int(i) 
        try:
            # print('In my try')
            for i in flatareaid_tuple:
                flatareaid = i
                #   flatID = i # uncomment this later
                # print("i",i)
                #x = i          # comment this later
        except Exception as e:
            # print('In my except')
            # print('error',e)
            # print("Flat with Block Number: {} and Flat Number: {} does not exist".format(blockno,flatno))
            continue
        # print(cursor.execute(flat_area_id, val))
        #print("id",flatareaid)
        values = (flatno, blockno, floor, flatareaid, timestamp, timestamp)

        try:
            if login_role in ['admin']:
                #print("here")
                update_values = (flatno, blockno, floor,flatareaid, timestamp, timestamp)
                insert_record(update_values, values)    

        except Exception as e:
            if "Duplicate entry" in str(e):
                if upload_constraint == "0":
                    #print("Co")
                    pass
                elif upload_constraint == "1":
                    values = (flatno, blockno, floor, flatareaid, timestamp, timestamp)
                    #print(values)
                    try:
                        # operation_performed = "UPDATE"
                        cursor.execute(update_flat, values)
                        updated_records_count += 1
                       
                    except Exception as e:
                        print(e)
                        print("error+" + str(e))
                        sys.exit(0)
                else:
                    print("error+Block No.: "+blockno+" and Flat No.: " +
                          flatno + " has duplicate entry.")
                    sys.exit(0)

            else:
                #print("ok")
                print("The upload was unsuccessful.")
                print(e)
                sys.exit(0)
except Exception as e:
    #print("ok")
    print(str(e))
    sys.exit(0)

connection.commit()
output = {"insertedRecords": inserted_records_count,
          "updatedRecords": updated_records_count, "totalRecords": data.nrows-1}
print('Successful+%s' %
      (json.dumps(output)))
connection.close()
