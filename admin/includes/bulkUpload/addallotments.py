import pymysql
import xlrd
import sys
import re
import json
mapper = {
    "added": 1,
    "timestamp": 2,
    "fno": 3,
    "block": 4,
    "oname": 5,
    "oemail": 6,
    "ocno": 7,
    "oacno": 8,
    "omem": 9,
    "isrent": 10,
    "rname": 11,
    "remail": 12,
    "rcno": 13,
    "racno": 14,
    "rmem": 15,
    "host": 16,
    "file_location": 17,
    "username_db": 18,    
    "dbname": 19,
    "password_db": 20,
    "upload_constraint": 21,
    "login_role": 22,
}

header = []
header_id = {}
end_col = 7
startcol_index = 3
passw = ""
#print(sys.argv)
file = xlrd.open_workbook(sys.argv[mapper['file_location']])
data = file.sheet_by_index(0)
for y in range(0, data.ncols):
    header.append(data.cell(0, y).value)
# print(header)
if len(sys.argv) != 23:
    #print("len",len(sys.argv))
    end_col = 7
else: 
    passw = sys.argv[mapper['password_db']]
try:
    #print(len(sys.argv)-end_col)
    for x in range(startcol_index, len(sys.argv)-end_col):
        # print("x:",sys.argv[x])
        header_id[sys.argv[x]] = header.index(sys.argv[x])


except Exception as e:
    # print("ex occured!")
    print(re.findall(r"'(.*?)'", str(e),)
          [0]+" is not a column in the uploaded sheet")
    sys.exit(0)

# print("hi")
insert_allotment = """ Insert into allotments(AllotmentID, FlatID, FlatNumber , BlockNumber, OwnerName , OwnerEmail, OwnerContactNumber, OwnerAlternateContactNumber, OwnerMemberCount, isRent, RenteeName , RenteeEmail, RenteeContactNumber, RenteeAlternateContactNumber, RenteeMemberCount , updated_by ,updated_at) VALUES('',%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s); """
update_allotment = "update allotments set OwnerName=%s, OwnerEmail=%s, OwnerContactNumber=%s, OwnerAlternateContactNumber=%s, OwnerMemberCount=%s, isRent=%s, RenteeName=%s, RenteeEmail=%s, RenteeContactNumber=%s, RenteeAlternateContactNumber=%s, RenteeMemberCount=%s, updated_by=%s,updated_at=%s where BlockNumber=%s and FlatNumber=%s"
flat_id = "select FlatID from flats where BlockNumber=%s and FlatNumber=%s"


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
        updated_records_count += cursor.execute(update_allotment, update_values)
        
    else:
        # operation_performed = "INSERT"
        # status = "Area record inserted"
        cursor.execute(insert_allotment, values_insert)
        inserted_records_count += 1        

try:
    # print("inside try")
    # print(data.nrows)
    for x in range(1, data.nrows):
        # print("in for loop")
        # print(x)
        # print(data.cell(x, header_id[sys.argv[mapper['block_col']]]).value)
        blockno = data.cell(
            x, header_id[sys.argv[mapper['block']]]).value
        # print("b",blockno)
        flatno = data.cell(
            x, header_id[sys.argv[mapper['fno']]]).value
        oname = data.cell(
            x, header_id[sys.argv[mapper['oname']]]).value
        oemail = data.cell(
            x, header_id[sys.argv[mapper['oemail']]]).value
        ocno = data.cell(
            x, header_id[sys.argv[mapper['ocno']]]).value
        oacno = data.cell(
            x, header_id[sys.argv[mapper['oacno']]]).value
        omem = data.cell(
            x, header_id[sys.argv[mapper['omem']]]).value
        isRent = data.cell(
            x, header_id[sys.argv[mapper['isrent']]]).value
        rname = data.cell(
            x, header_id[sys.argv[mapper['rname']]]).value
        remail = data.cell(
            x, header_id[sys.argv[mapper['remail']]]).value
        rcno = data.cell(
            x, header_id[sys.argv[mapper['rcno']]]).value
        racno = data.cell(
            x, header_id[sys.argv[mapper['racno']]]).value
        rmem = data.cell(
            x, header_id[sys.argv[mapper['rmem']]]).value
        val = (blockno, flatno)
        cursor.execute(flat_id,val)
        flatid_tuple = cursor.fetchall()
        #print(flatid_tuple)
        for i in flatid_tuple:
            flatid = i

        if(isRent == "Yes"):
            isRent = 1
        elif(isRent == "No"):
            isRent = 0
            rname = remail = rcno = racno = rmem = "-"
        values = (flatid, flatno, blockno, oname, oemail, ocno, oacno, omem, isRent , rname, remail, rcno, racno, rmem, added, timestamp)

        try:
            if login_role in ['admin']:
                update_values = (oname, oemail, ocno, oacno, omem, isRent , rname, remail, rcno, racno, rmem, added, timestamp, blockno, flatno)
                insert_record(update_values, values)    

        except Exception as e:
            if "Duplicate entry" in str(e):
                if upload_constraint == "0":
                    pass
                elif upload_constraint == "1":
                    values = (oname, oemail, ocno, oacno, omem, isRent , rname, remail, rcno, racno, rmem, added, timestamp, blockno, flatno)
                    try:
                        # operation_performed = "UPDATE"
                        cursor.execute(update_allotment, values)
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
