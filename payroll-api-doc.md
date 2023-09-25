# Project: Payroll PT. Mau Maju
# Getting Started

## Step 1: Request API KEY

API KEY ini digunakan untuk setiap request ke semua endpoint URI pada sistem payroll ini, terutama untuk request pada data attendance (presensi) yang nantinya digunakan sebagai bahan perhitungan untuk menghitung totalan gaji karyawan. Kami merekomendasikan penggunaan API KEY dengan memasukkan nilai pada tab Variabel

## Step 2: Buat Call Request API Anda

Silahkan buat call request API Anda sesuai dengan method yang dibutuhkan untuk mendapatkan data attendance seperti :

- data attendance berdasarkan bulan
- data attendance berdasarkan karywan
- data attendance berdasarkan karyawan dan bulan
- data attendance untuk kebutuhan datatable
    

Masing-masing request API bisa dilihat pada bagiannya masing-masing pula, seperti penjelasan lebih lanjut, cara melakukan request API dan hasil response yang didapatkan.
# 📁 Collection: Attendance 


## End-point: attendance by employee and monthYear
Request ini digunakan untuk mendapatkan hasil attendance berdasarkan karyawan dan bulan-tahun yang diinginkan. Hasil request ini akan mengembalikan 1 data yang berisi hasil attendance karyawan berdasarkan parameter `empId` dan `monthYear` yang telah dimasukkan.
### Method: GET
>```
>{{API_URI}}employees/attendances/?empId=1695317171&monthYear=09-2023
>```
### Headers

|Content-Type|Value|
|---|---|
|API-KEY|{{API_KEY}}|


### Query Params

|Param|value|
|---|---|
|empId|1695317171|
|monthYear|09-2023|


### Response: 200
```json
{
    "status": true,
    "data": {
        "id_attendance": "1695321539",
        "employee_id": "1695317172",
        "workdays": "5",
        "nwnp": "16",
        "overtime": "15",
        "overtime_pay": "277457"
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: attendance datatables
Request ini digunakan untuk mendapatkan hasil attendance berdasarkan parameter library datatables, yaitu `start`, `length`, `orderIndex`, `orderSort` dan tambahan parameter berdasarkan `empId` dan `monthYear` dengan format _m-Y_. Hasil request ini akan mengembalikan data yang berisi data attendance termasuk data karyawan berdasarkan parameter yang dimasukkan.
### Method: GET
>```
>{{API_URI}}employees/attendances/datatables/?empId=semua&monthYear=09-2023&start=0&length=10&search&orderIndex=1&orderSort=asc
>```
### Headers

|Content-Type|Value|
|---|---|
|API-KEY|{{API_KEY}}|


### Query Params

|Param|value|
|---|---|
|empId|semua|
|monthYear|09-2023|
|start|0|
|length|10|
|search|null|
|orderIndex|1|
|orderSort|asc|


### Response: 200
```json
{
    "status": true,
    "data": {
        "count_filtered": 29,
        "count_all": 29,
        "attendances": [
            {
                "id_attendance": "1695321539",
                "employee_id": "1695317172",
                "attendance_date": "2023-09-04",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "2",
                "overtime_pay": "0",
                "name": "Agung Brastama",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Laki-laki",
                "job_designation": "Manager",
                "status": "Tetap",
                "basic_salary": "7000000",
                "allowance": "1000000",
                "date_of_join": "2022-09-04",
                "has_BPJS": "1"
            },
            {
                "id_attendance": "1695321540",
                "employee_id": "1695317172",
                "attendance_date": "2023-09-05",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "7",
                "overtime_pay": "0",
                "name": "Agung Brastama",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Laki-laki",
                "job_designation": "Manager",
                "status": "Tetap",
                "basic_salary": "7000000",
                "allowance": "1000000",
                "date_of_join": "2022-09-04",
                "has_BPJS": "1"
            },
            {
                "id_attendance": "1695321544",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-09",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "6",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            },
            {
                "id_attendance": "1695321545",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-10",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "2",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            },
            {
                "id_attendance": "1695321546",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-11",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "8",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            },
            {
                "id_attendance": "1695321547",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-12",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "6",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            },
            {
                "id_attendance": "1695321548",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-13",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "3",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            },
            {
                "id_attendance": "1695321549",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-14",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "1",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            },
            {
                "id_attendance": "1695321550",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-15",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "8",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            },
            {
                "id_attendance": "1695321551",
                "employee_id": "1695317171",
                "attendance_date": "2023-09-16",
                "signin_time": "08:00:00",
                "signout_time": "16:00:00",
                "working_hour": "8",
                "overtime": "6",
                "overtime_pay": "0",
                "name": "Seftin Fitri Ana Wato",
                "birth_place": "Surabaya",
                "birth_date": "1990-03-02",
                "gender": "Perempuan",
                "job_designation": "Operasional",
                "status": "Kontrak",
                "basic_salary": "5000000",
                "allowance": "1000000",
                "date_of_join": "2023-09-04",
                "has_BPJS": "0"
            }
        ]
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: attendance by month
Request ini digunakan untuk mendapatkan hasil attendance berdasarkan parameter `monthYear` dengan format _m-Y_. Hasil request ini akan mengembalikan data yang berisi data attendance semua data karyawan berdasarkan parameter `monthYear` yang dimasukkan.
### Method: GET
>```
>{{API_URI}}employees/attendances/months/?monthYear=09-2023
>```
### Headers

|Content-Type|Value|
|---|---|
|API-KEY|{{API_KEY}}|


### Query Params

|Param|value|
|---|---|
|monthYear|09-2023|


### Response: 200
```json
{
    "status": true,
    "data": [
        {
            "id_attendance": "1695321544",
            "employee_id": "1695317171",
            "name": "Seftin Fitri Ana Wato",
            "birth_place": "Surabaya",
            "birth_date": "1990-03-02",
            "gender": "Perempuan",
            "job_designation": "Operasional",
            "status": "Kontrak",
            "basic_salary": "5000000",
            "allowance": "1000000",
            "date_of_join": "2023-09-04",
            "has_BPJS": "0",
            "workdays": "21",
            "month_year": "Sep-2023",
            "nwnp": "0",
            "overtime": "112",
            "overtime_pay": "416185"
        },
        {
            "id_attendance": "1695321539",
            "employee_id": "1695317172",
            "name": "Agung Brastama",
            "birth_place": "Surabaya",
            "birth_date": "1990-03-02",
            "gender": "Laki-laki",
            "job_designation": "Manager",
            "status": "Tetap",
            "basic_salary": "7000000",
            "allowance": "1000000",
            "date_of_join": "2022-09-04",
            "has_BPJS": "1",
            "workdays": "5",
            "month_year": "Sep-2023",
            "nwnp": "16",
            "overtime": "15",
            "overtime_pay": "277457"
        }
    ]
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: attendance by employee
Request ini digunakan untuk mendapatkan hasil attendance berdasarkan parameter `empId`. Hasil request ini akan mengembalikan data yang berisi data attendance data karyawan berdasarkan parameter `empId` yang dimasukkan di semua record data attendance.
### Method: GET
>```
>{{API_URI}}employees/attendances/employees/?empId=1695317171
>```
### Headers

|Content-Type|Value|
|---|---|
|API-KEY|{{API_KEY}}|


### Query Params

|Param|value|
|---|---|
|empId|1695317171|


### Response: 200
```json
{
    "status": true,
    "data": [
        {
            "id_attendance": "1695321541",
            "employee_id": "1695317171",
            "name": "Seftin Fitri Ana Wato",
            "birth_place": "Surabaya",
            "birth_date": "1990-03-02",
            "gender": "Perempuan",
            "job_designation": "Operasional",
            "status": "Kontrak",
            "basic_salary": "5000000",
            "allowance": "1000000",
            "date_of_join": "2023-09-04",
            "has_BPJS": "0",
            "workdays": "3",
            "month_year": "Aug-2023",
            "nwnp": "20",
            "overtime": "10",
            "overtime_pay": "0"
        },
        {
            "id_attendance": "1695321544",
            "employee_id": "1695317171",
            "name": "Seftin Fitri Ana Wato",
            "birth_place": "Surabaya",
            "birth_date": "1990-03-02",
            "gender": "Perempuan",
            "job_designation": "Operasional",
            "status": "Kontrak",
            "basic_salary": "5000000",
            "allowance": "1000000",
            "date_of_join": "2023-09-04",
            "has_BPJS": "0",
            "workdays": "21",
            "month_year": "Sep-2023",
            "nwnp": "0",
            "overtime": "112",
            "overtime_pay": "416185"
        }
    ]
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: attendance by id
Request ini digunakan untuk mendapatkan hasil attendance berdasarkan parameter `id` yaitu id attendance. Hasil request ini akan mengembalikan data yang berisi data attendance data karyawan berdasarkan parameter `id` yang dimasukkan.
### Method: GET
>```
>{{API_URI}}employees/attendances/id/?id=1695537928
>```
### Headers

|Content-Type|Value|
|---|---|
|API-KEY|{{API_KEY}}|


### Query Params

|Param|value|
|---|---|
|id|1695537928|


### Response: 200
```json
{
    "status": true,
    "data": {
        "id_attendance": "1695537928",
        "employee_id": "1695317172",
        "attendance_date": "2023-09-03",
        "signin_time": "08:00:00",
        "signout_time": "17:00:00",
        "working_hour": "9",
        "overtime": "1",
        "overtime_pay": "46243"
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: attendance
Request ini digunakan untuk menambahkan data attendance karyawan. Hasil request ini akan mengembalikan data yang berisi data attendance karyawan yang telah dimasukkan. Adapun data body yang diperlukan yaitu `empId`, `attendance_date` dan `signin_time`
### Method: POST
>```
>{{API_URI}}employees/attendances/
>```
### Headers

|Content-Type|Value|
|---|---|
|API-KEY|{{API_KEY}}|


### Body formdata

|Param|value|Type|
|---|---|---|
|empId|1695317172|text|
|attendance_date|2023-09-03|text|
|signin_time|08:00|text|


### Response: 200
```json
{
    "status": true,
    "data": {
        "id_attendance": 1695537928,
        "employee_id": "1695317172",
        "attendance_date": "2023-09-03",
        "signin_time": "08:00"
    }
}
```


⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃ ⁃

## End-point: attendance
Request ini digunakan untuk mengubah data attendance karyawan yang telah dimasukkan sebelumnya. Hasil request ini akan mengembalikan data yang berisi data attendance karyawan yang telah dimasukkan. Adapun data body yang diperlukan yaitu `id_attendance` sebagai identifier data dan `signout_time` sebagai data penambah yang ingin dimasukkan pada data attendance
### Method: PATCH
>```
>{{API_URI}}employees/attendances/
>```
### Headers

|Content-Type|Value|
|---|---|
|API-KEY|{{API_KEY}}|


### Response: 200
```json
{
    "status": true,
    "data": {
        "id_attendance": "1695537928",
        "employee_id": "1695317172",
        "attendance_date": "2023-09-03",
        "signin_time": "08:00:00",
        "signout_time": "18:00:00",
        "working_hour": "10",
        "overtime": "2",
        "overtime_pay": "92486"
    }
}
```

