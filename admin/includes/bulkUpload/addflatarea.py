import pymysql
import xlrd
import sys
import re
import json
mapper = {
    "added": 1,
    "timestamp": 2,
    "block_col": 3,
    "series_col": 4,
    "flattype_col": 5,
    "area_col": 6,
    "rate_col": 7,
    "host": 9,
    "username_db": 11,
    "password_db": 13,
    "dbname": 12,
    "file_location": 10,    
    "upload_constraint": 14,
    "login_role": 15,
}

header = []
header_id = {}
end_col = 8
startcol_index = 3
passw = ""
file = xlrd.open_workbook(sys.argv[mapper['file_location']])
data = file.sheet_by_index(0)
for y in range(0, data.ncols):
    header.append(data.cell(0, y).value)
# print(header)
if len(sys.argv) != 16:
    # print("len",len(sys.argv))
    end_col = 5
else: 
    passw = sys.argv[mapper['password_db']]
try:
    for x in range(startcol_index, len(sys.argv)-end_col):
        # print("x:",sys.argv[x])
        header_id[sys.argv[x]] = header.index(sys.argv[x])


except Exception as e:
    # print("ex occured!")
    print(re.findall(r"'(.*?)'", str(e),)
          [0]+" is not a column in the uploaded sheet")
    sys.exit(0)

# print("hi")
insert_area = """ Insert into flatarea(FlatAreaID, BlockNumber, FlatSeries , FlatArea , FlatType , Ratepsq , Updatedby ,UpdatedAt) VALUES('',%s,%s,%s,%s,%s,%s,%s); """
update_area = "update flatarea set FlatArea=%s,FlatType=%s,Ratepsq=%s,Updatedby=%s,UpdatedAt=%s where BlockNumber=%s and FlatSeries=%s"


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
added = sys.argv[mapper['added']]
upload_constraint = sys.argv[mapper['upload_constraint']]
login_role = sys.argv[mapper['login_role']]
# print("hi")
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
        updated_records_count += cursor.execute(update_area, update_values)
        
    else:
        # operation_performed = "INSERT"
        # status = "Area record inserted"
        cursor.execute(insert_area, values_insert)
        inserted_records_count += 1        

try:
    # print("inside try")
    # print(data.nrows)
    for x in range(1, data.nrows):
        # print("in for loop")
        # print(x)
        # print(data.cell(x, header_id[sys.argv[mapper['block_col']]]).value)
        blockno = data.cell(
        x, header_id[sys.argv[mapper['block_col']]]).value
        # print("b",blockno)
        seriesno = data.cell(x, header_id[sys.argv[mapper['series_col']]]).value
        seriesno = str(int(seriesno)).zfill(2)
        # print(seriesno)
        flattype = data.cell(
            x, header_id[sys.argv[mapper['flattype_col']]]).value.upper()  
        flatarea = data.cell(
            x, header_id[sys.argv[mapper['area_col']]]).value
        frate = data.cell(
            x, header_id[sys.argv[mapper['rate_col']]]).value
        values = (blockno, seriesno, flatarea, flattype, frate, added, timestamp)

        try:
            if login_role in ['admin']:
                update_values = (flatarea, flattype, frate, added, timestamp, blockno, seriesno)
                insert_record(update_values, values)    

        except Exception as e:
            if "Duplicate entry" in str(e):
                if upload_constraint == "0":
                    pass
                elif upload_constraint == "1":
                    values = (flatarea, flattype, frate, added, timestamp, blockno, seriesno)
                    try:
                        # operation_performed = "UPDATE"
                        cursor.execute(update_area, values)
                        updated_records_count += 1
                       
                    except Exception as e:
                        print(e)
                        print("error+" + str(e))
                        sys.exit(0)
                else:
                    print("error+Block No.: "+blockno+" and Series No.: " +
                          seriesno + " has duplicate entry.")
                    sys.exit(0)

            else:
                print("The upload was unsuccessful.")
                print(e)
                sys.exit(0)
except Exception as e:
    print(str(e))
    sys.exit(0)

connection.commit()
output = {"insertedRecords": inserted_records_count,
          "updatedRecords": updated_records_count, "totalRecords": data.nrows-1}
print('Successful+%s' %
      (json.dumps(output)))
connection.close()
