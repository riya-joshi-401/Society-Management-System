import pymysql
import xlrd
import sys
import re
import json
from datetime import datetime
import random

mapper = {
    "added": 1,
    "timestamp": 2,
    "vname_col": 3,
    "vcno_col": 4,
    "alternatevcno_col": 5,
    "block_col": 6,
    "flatno_col": 7,
    "people_col": 8,
    "whom_col": 9,
    "reason_col": 10,
    "startdate_col": 11,
    "duration_col": 12,
    "host": 13,
    "username_db": 15,
    "password_db": 17,
    "dbname": 16,
    "file_location": 14,   
    "upload_constraint": 18,
    "login_role": 19,
}

header = []
header_id = {}
end_col = 7 
startcol_index = 3
passw = ""
file = xlrd.open_workbook(sys.argv[mapper['file_location']])
data = file.sheet_by_index(0)
for y in range(0, data.ncols):
    header.append(data.cell(0, y).value)
# print(header)
if len(sys.argv) != 20:
    # print("len",len(sys.argv))
    end_col = 7
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

insert_visitors = """ Insert into visitors(VisitorID, FlatID, VisitorName, VisitorContactNo, AlternateVisitorContactNo, BlockNumber, FlatNumber, NoOfPeople, WhomToMeet, ReasonToMeet, OTP, StartDate, Duration, updated_by, updated_at)
                        VALUES('',%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s); """

update_visitors = "update visitors set VisitorContactNo=%s, WhomToMeet=%s, ReasonToMeet=%s, NoOfPeople=%s, StartDate=%s, Duration=%s, updated_by=%s,updated_at=%s where BlockNumber=%s and FlatNumber=%s and VisitorName=%s"

# fetch Flat Id from flats table
flatId = "select FlatID from flats where BlockNumber=%s and FlatNumber=%s"

# print(sys.argv[mapper['dbname']])
# print("hi")
connection = pymysql.connect(host=sys.argv[mapper['host']],
                             user=sys.argv[mapper['username_db']],
                             passwd=passw,
                            #  port=3325,
                             database=sys.argv[mapper['dbname']])
#print("hi conn established!")
cursor = connection.cursor()
#print(cursor)
timestamp = sys.argv[mapper['timestamp']]
added = sys.argv[mapper['added']]
upload_constraint = sys.argv[mapper['upload_constraint']]
login_role = sys.argv[mapper['login_role']]
# print("hi")
password_set = 0
inserted_records_count = 0
updated_records_count = 0
send_otp_list = {}

def insert_otp(check_query_values, otp):
    global send_otp_list

    # print("In insert otp func")
    otp_query_values = list(check_query_values)
    otp_query_values.insert(0,otp)
    # print("otp_query_values",otp_query_values)

    otp_query_values = tuple(otp_query_values)
    # print("after tuple converion otp_query_values: ",otp_query_values)

    otp_query = "update visitors set OTP=%s where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
    cursor.execute(otp_query, otp_query_values)
            

def update_otp(check_sd_values,otp):
    # print("in update otp func")
    # print("Changed the date or duration")

    otp_query_values = list(check_sd_values)
    otp_query_values.insert(0,otp)
    # print("otp_query_values",otp_query_values)
    otp_query_values = tuple(otp_query_values)
    # print("after tuple converion otp_query_values: ",otp_query_values)

    otp_query = "update visitors set OTP=%s where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
    cursor.execute(otp_query, otp_query_values)

def check_sd(update_values):
    # print("in check sd func")
    check_sd_query = "select StartDate, Duration from visitors where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
    check_sd_values = (update_values[8],update_values[9],update_values[10])
    res= cursor.execute(check_sd_query, check_sd_values)
    row = cursor.fetchone()

    return check_sd_values,row

def insert_record(update_values, values_insert):
    global updated_records_count, inserted_records_count, send_otp_list
    # operation_performed = ""
    # status = ""

    if sys.argv[mapper['upload_constraint']] == "2":
        # operation_performed = "UPDATE"
        # status = "updated details " 

        # print("update_values",update_values)
        
        # check whether the duration or startdate is been changed or not
        # print('In my update')

        # check_sd_query = "select StartDate, Duration from visitors where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
        # check_sd_values = (update_values[8],update_values[9],update_values[10])
        # res= cursor.execute(check_sd_query, check_sd_values)
        # row = cursor.fetchone()
        # # print("result from query", row)

        check_sd_values,row = check_sd(update_values) 

        startdate_old = row[0]
        duration_old = row[1]
        
        startdate_new = update_values[4]
        duration_new = update_values[5] 

        if ((startdate_new != startdate_old) or (duration_new != duration_old)):
            
            otp = random.randint(100000, 999999)
            # print("otp", otp)
            update_otp(check_sd_values,otp)

            # print("Changed the date or duration")
            # otp = random.randint(100000, 999999)
            # print("otp", otp)

            # otp_query_values = list(check_sd_values)
            # otp_query_values.insert(0,otp)
            # # print("otp_query_values",otp_query_values)
            # otp_query_values = tuple(otp_query_values)
            # print("after tuple converion otp_query_values: ",otp_query_values)

            # otp_query = "update visitors set OTP=%s where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
            # cursor.execute(otp_query, otp_query_values)

            check_duration = duration_new if duration_new !=duration_old else duration_old
            send_otp_list[otp] = [update_values[0],check_duration]
            # print("send_otp_list: ",send_otp_list)


        updated_records_count += cursor.execute(update_visitors, update_values)

    elif sys.argv[mapper['upload_constraint']] == "1":
        
        # print("values passed",values_insert)
        compare_tuple = (values_insert[0],values_insert[1],values_insert[4],values_insert[5])
        # print("compare tuple",compare_tuple)
        check_query_values = (values_insert[4],values_insert[5],values_insert[1])
        check_query = "select FlatID, VisitorName, BlockNumber, FlatNumber from visitors where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
        cursor.execute(check_query, check_query_values)
        result = cursor.fetchone()
        # print("result",result)

        if compare_tuple == result:
            # print('Record Already Exists!')
            # print('So updating the further!')
            # print(update_values)

            check_sd_values,row = check_sd(update_values)  # Function
        
            startdate_old = row[0]
            duration_old = row[1]
            startdate_new = update_values[4]
            duration_new = update_values[5] 

            if ((startdate_new != startdate_old) or (duration_new != duration_old)):
                
                otp = random.randint(100000, 999999)
                # print("otp", otp)
                update_otp(check_sd_values,otp) # Function
                check_duration = duration_new if duration_new !=duration_old else duration_old
                send_otp_list[otp] = [update_values[0],check_duration]
                # print("send_otp_list: ",send_otp_list)

            updated_records_count += cursor.execute(update_visitors, update_values)
            

        elif (cursor.rowcount) == 0:
            # print('Inserting the Record')
            # print(values_insert)
            
            otp = random.randint(100000, 999999)
            # print("otp", otp)

            # Query for checking whether the record exists or not in DB
            check_query_values = (values_insert[4],values_insert[5],values_insert[1])
            check_query = "select * from visitors where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
            cursor.execute(check_query, check_query_values)


            cursor.execute(insert_visitors, values_insert) # insert query

            insert_otp(check_query_values, otp) # Function

            send_otp_list[otp] = [values_insert[2],values_insert[11]]
            # print("send_otp_list: ",send_otp_list)
            inserted_records_count += 1  

        
    else:
        # operation_performed = "INSERT"
        # status = "Area record inserted"
        
        # print('In my insert part')
        
        # print("values_insert: ",values_insert)

        otp = random.randint(100000, 999999)
        # print("otp", otp)

        # Query for checking whether the record exists or not in DB
        check_query_values = (values_insert[4],values_insert[5],values_insert[1])
        check_query = "select * from visitors where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
        cursor.execute(check_query, check_query_values)

        if cursor.rowcount != 0:
            # print('Record Already Exists!')
            pass
        else:
            # print('Inserting the Record')
            cursor.execute(insert_visitors, values_insert)

            insert_otp(check_query_values, otp) #Function

            # otp_query_values = list(check_query_values)
            # otp_query_values.insert(0,otp)
            # print("otp_query_values",otp_query_values)

            # otp_query_values = tuple(otp_query_values)
            # print("after tuple converion otp_query_values: ",otp_query_values)

            # otp_query = "update visitors set OTP=%s where BlockNumber = %s and FlatNumber=%s and VisitorName=%s"
            # cursor.execute(otp_query, otp_query_values)

            send_otp_list[otp] = [values_insert[2],values_insert[11]]
            # print("send_otp_list: ",send_otp_list)
            inserted_records_count += 1        

try:
    # print("inside try")
    # print(data.nrows)
    for x in range(1, data.nrows):
        # print("in for loop")
        # print(x)
        # print(data.cell(x, header_id[sys.argv[mapper['block_col']]]).value)
        
        vname = data.cell(x, header_id[sys.argv[mapper['vname_col']]]).value

        vcno = int(data.cell(x, header_id[sys.argv[mapper['vcno_col']]]).value)

        alternatevcno = int(data.cell(x, header_id[sys.argv[mapper['alternatevcno_col']]]).value)

        blockno = data.cell(x, header_id[sys.argv[mapper['block_col']]]).value
        
        flatno = int(data.cell(x, header_id[sys.argv[mapper['flatno_col']]]).value)

        people = int(data.cell(x, header_id[sys.argv[mapper['people_col']]]).value)

        whom = data.cell(x, header_id[sys.argv[mapper['whom_col']]]).value

        reason = data.cell(x, header_id[sys.argv[mapper['reason_col']]]).value

        excel_date = data.cell(x, header_id[sys.argv[mapper['startdate_col']]]).value
        # print("excel_date",excel_date)
        startdate = datetime(*xlrd.xldate_as_tuple(excel_date, 0))
        startdate = startdate.date()
        # print("startdate",startdate)

        duration = int(data.cell(x, header_id[sys.argv[mapper['duration_col']]]).value)

        val = (str(blockno),flatno)
        # print(val)
        cursor.execute(flatId, val)  # executing the fetch flatId query
        flatId_tuple = cursor.fetchone()

        flatID = 2 # remove this later
        # print("flatid",flatID)
        
        # print('flatid_tuple',flatId_tuple)
        try:
            # print('In my try')
            for i in flatId_tuple:
                #   flatID = i # uncomment this later
                # print("i",i)
                x = i          # comment this later
        except Exception as e:
            # print('In my except')
            # print('error',e)
            # print("Flat with Block Number: {} and Flat Number: {} does not exist".format(blockno,flatno))
            continue

        otp = 0 #defined

        #for Insert query
        values = (flatID, vname, vcno, alternatevcno, blockno, flatno, people, whom, reason, otp, startdate, duration, added, timestamp)
        

        try:
            if login_role in ['admin']: 
                update_values = (vcno, whom, reason, people, startdate, duration, added, timestamp, blockno, flatno,vname)
                insert_record(update_values, values)    

        except Exception as e:
            if "Duplicate entry" in str(e):
                if upload_constraint == "0":
                    pass
                elif upload_constraint == "1":
                    values = (vcno, whom, reason, people, startdate, duration, added, timestamp, blockno, flatno,vname)
                    try:
                        # operation_performed = "UPDATE"
                        cursor.execute(update_visitors, values)
                        updated_records_count += 1
                       
                    except Exception as e:
                        print(e)
                        print("error+" + str(e))
                        sys.exit(0)
                else:
                    print("error+Block No.: "+blockno+", Flat No.: " +
                          flatno + " and Visitor Name: "+vname+" has duplicate entry.")
                    sys.exit(0)
            elif "'NoneType' object" in str(e):
                # print("Reached")
                if upload_constraint == "2":
                    pass

            else:
                print("The upload was unsuccessful.")
                print(e)
                sys.exit(0)
except Exception as e:
    print(str(e))
    sys.exit(0)

connection.commit()
output = {"insertedRecords": inserted_records_count,
          "updatedRecords": updated_records_count, "totalRecords": data.nrows-1,"otp_list": send_otp_list}
# print('output',output)
print('Successful+ %s' %
      (json.dumps(output)))
connection.close()
