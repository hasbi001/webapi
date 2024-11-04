<html>
<head>
    <title>Pengguna</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<style>
    	table{
        	border : 1px solid black;
        }
        
        th {
        	border : 1px dotted black;
            height: 40px;  
        	padding : 4px;
			background-color: orange;
			color: white;
        }
        
        td {
        	border : 1px dotted black;
            height: 40px;  
        	padding : 4px;
        }
        
        button{
        	width: 130px;
			background-color: orange;
			color: white;
			border: 1px solid orange;
			cursor: pointer;
			padding: 4px;
			border-radius: 4px;
        }
		
		button:hover{
			color: orangered;
			font-weight: bold;
			border: 2px solid orangered;
		}
        
        .right {
        	text-align:right;
        }
        
         .center {
        	text-align:center;
        }
    </style>
    
    <script>
      function InitializeData(){
        const url = 'http://localhost:8000/api/list';
        $("#afterpage").val('FALSE');
        $("#firstpage").val('TRUE');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                totalpage: $("#totalpage").val(),
                beforepage: $("#beforepage").val(),
                afterpage: $("#afterpage").val(),
                firstpage: $("#firstpage").val(),
                lastpage: $("#lastpage").val()
            },
            dataType: "JSON",
            success: function (data) {
                var datalist = data.list;
                console.log(data);
                var list = '';
                datalist.forEach((item,index) => {
                    list = list+'<tr>';
                        list = list+'<td>'+item.no+'</td>';
                        list = list+'<td>'+item.id+'</td>';
                        list = list+'<td>'+item.name+'</td>';
                        list = list+'<td>'+item.birthdate+'</td>';
                        list = list+'<td>'+item.age+'</td>';
                    list = list+'</tr>';
                });
                $("#table tbody").append(list);
            }
            
        });
      }
      
      function InitializeUI(){
        	document.getElementById("lblToday").innerHTML = "Today : " + dtmToday.ToString();

            uiList.push(new UiData("lblItemOfNo1", "lblItemOfId1", "lblItemOfName1", "lblItemOfBirthday1", "lblItemOfAge1"));
            uiList.push(new UiData("lblItemOfNo2", "lblItemOfId2", "lblItemOfName2", "lblItemOfBirthday2", "lblItemOfAge2"));
            uiList.push(new UiData("lblItemOfNo3", "lblItemOfId3", "lblItemOfName3", "lblItemOfBirthday3", "lblItemOfAge3"));
            uiList.push(new UiData("lblItemOfNo4", "lblItemOfId4", "lblItemOfName4", "lblItemOfBirthday4", "lblItemOfAge4"));
            uiList.push(new UiData("lblItemOfNo5", "lblItemOfId5", "lblItemOfName5", "lblItemOfBirthday5", "lblItemOfAge5"));
      }
      
      Date.prototype.ToString = function(){
      		return this.getFullYear().ToString() + "-" + 
            	   (this.getMonth() + 1).ToString() + "-" + 
                   this.getDate().ToString();
      }
      
      Number.prototype.ToString = function(){
          if (this >= 0 && this <= 9)	
              return "0" + String(this);
          else
              return String(this);
      }

      function NewDate(year, month, date){
            return new Date(year, month-1, date);
      }
	  
	  const dtmToday = NewDate(2023, 4, 12);
      const employeeList = [];
      const uiList = [];
    
      function EmployeeData(szId, szName, dtmBirthday){
      		this.szId = szId == undefined ? "" : szId;
            this.szName = szName == undefined ? "" : szName;
            this.dtmBirthday = dtmBirthday == undefined ? NewDate(1900, 1, 1) : dtmBirthday;
      }
      
      function UiData(lblNo, lblId, lblName, lblBirthday, lblAge){
      		this.lblNo = document.getElementById(lblNo);
            this.lblId = document.getElementById(lblId);
            this.lblName = document.getElementById(lblName);
            this.lblBirthday = document.getElementById(lblBirthday);
            this.lblAge = document.getElementById(lblAge);
      }
      
	  function DoInitialize(){
 			InitializeData();
        	InitializeUI();     
            btnFirst_Click();
      }

      ///////////////////////////
      // COMPLETE THE FUNCTION //
      //         BEGIN         //
      ///////////////////////////

      function btnFirst_Click(){
        const url = 'http://localhost:8000/api/list';
        $("#afterpage").val('FALSE');
        $("#firstpage").val('FALSE');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                totalpage: $("#totalpage").val(),
                beforepage: 'TRUE',
                afterpage: 'FALSE',
                firstpage: $("#firstpage").val(),
                lastpage: $("#lastpage").val()
            },
            dataType: "JSON",
            success: function (data) {
                var datalist = data.list;
                console.log(data);
                var list = '';
                datalist.forEach((item,index) => {
                    list = list+'<tr>';
                        list = list+'<td>'+item.no+'</td>';
                        list = list+'<td>'+item.id+'</td>';
                        list = list+'<td>'+item.name+'</td>';
                        list = list+'<td>'+item.birthdate+'</td>';
                        list = list+'<td>'+item.age+'</td>';
                    list = list+'</tr>';
                });
                $("#table tbody").append(list);
            }
            
        }); 
      }

      function btnPreviousPage_Click(){
        $("#lastpage").val('FALSE');
        $("#firstpage").val('FALSE');
        var b = parseInt($("#beforepage").val())-2;
        $("#beforepage").val(b);
        var a = parseInt($("#afterpage").val())-2;
        $("#afterpage").val(a);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                totalpage: $("#totalpage").val(),
                beforepage: b,
                afterpage: a,
                firstpage: $("#firstpage").val(),
                lastpage: $("#lastpage").val()
            },
            dataType: "JSON",
            success: function (data) {
                var datalist = data.list;
                console.log(data);
                var list = '';
                datalist.forEach((item,index) => {
                    list = list+'<tr>';
                        list = list+'<td>'+item.no+'</td>';
                        list = list+'<td>'+item.id+'</td>';
                        list = list+'<td>'+item.name+'</td>';
                        list = list+'<td>'+item.birthdate+'</td>';
                        list = list+'<td>'+item.age+'</td>';
                    list = list+'</tr>';
                });
                $("#table tbody").append(list);
            }
            
        });
      }

      function btnPrevious_Click(){
        $("#lastpage").val('FALSE');
        $("#firstpage").val('FALSE');
        var b = parseInt($("#beforepage").val())-1;
        $("#beforepage").val(b);
        var a = parseInt($("#afterpage").val())-1;
        $("#afterpage").val(a);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                totalpage: $("#totalpage").val(),
                beforepage: b,
                afterpage: a,
                firstpage: $("#firstpage").val(),
                lastpage: $("#lastpage").val()
            },
            dataType: "JSON",
            success: function (data) {
                var datalist = data.list;
                console.log(data);
                var list = '';
                datalist.forEach((item,index) => {
                    list = list+'<tr>';
                        list = list+'<td>'+item.no+'</td>';
                        list = list+'<td>'+item.id+'</td>';
                        list = list+'<td>'+item.name+'</td>';
                        list = list+'<td>'+item.birthdate+'</td>';
                        list = list+'<td>'+item.age+'</td>';
                    list = list+'</tr>';
                });
                $("#table tbody").append(list);
            }
            
        });
	
      }
      
      function btnNext_Click(){
        $("#lastpage").val('FALSE');
        $("#firstpage").val('FALSE');
        var b = parseInt($("#beforepage").val())+1;
        $("#beforepage").val(b);
        var a = parseInt($("#afterpage").val())+1;
        $("#afterpage").val(a);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                totalpage: $("#totalpage").val(),
                beforepage: b,
                afterpage: a,
                firstpage: $("#firstpage").val(),
                lastpage: $("#lastpage").val()
            },
            dataType: "JSON",
            success: function (data) {
                var datalist = data.list;
                console.log(data);
                var list = '';
                datalist.forEach((item,index) => {
                    list = list+'<tr>';
                        list = list+'<td>'+item.no+'</td>';
                        list = list+'<td>'+item.id+'</td>';
                        list = list+'<td>'+item.name+'</td>';
                        list = list+'<td>'+item.birthdate+'</td>';
                        list = list+'<td>'+item.age+'</td>';
                    list = list+'</tr>';
                });
                $("#table tbody").append(list);
            }
            
        });
 
      }
      
      function btnNextPage_Click(){
        $("#lastpage").val('FALSE');
        $("#firstpage").val('FALSE');
        var b = parseInt($("#beforepage").val())+2;
        $("#beforepage").val(b);
        var a = parseInt($("#afterpage").val())+2;
        $("#afterpage").val(a);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                totalpage: $("#totalpage").val(),
                beforepage: b,
                afterpage: a,
                firstpage: $("#firstpage").val(),
                lastpage: $("#lastpage").val()
            },
            dataType: "JSON",
            success: function (data) {
                var datalist = data.list;
                console.log(data);
                var list = '';
                datalist.forEach((item,index) => {
                    list = list+'<tr>';
                        list = list+'<td>'+item.no+'</td>';
                        list = list+'<td>'+item.id+'</td>';
                        list = list+'<td>'+item.name+'</td>';
                        list = list+'<td>'+item.birthdate+'</td>';
                        list = list+'<td>'+item.age+'</td>';
                    list = list+'</tr>';
                });
                $("#table tbody").append(list);
            }
            
        });
      }
      
      function btnLast_Click(){
        const url = 'http://localhost:8000/api/list';
        $("#firstpage").val('FALSE');
        $("#lastpage").val('TRUE');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                totalpage: $("#totalpage").val(),
                beforepage: $("#beforepage").val(),
                afterpage: $("#afterpage").val(),
                firstpage: $("#firstpage").val(),
                lastpage: $("#lastpage").val()
            },
            dataType: "JSON",
            success: function (data) {
                var datalist = data.list;
                console.log(data);
                var list = '';
                datalist.forEach((item,index) => {
                    list = list+'<tr>';
                        list = list+'<td>'+item.no+'</td>';
                        list = list+'<td>'+item.id+'</td>';
                        list = list+'<td>'+item.name+'</td>';
                        list = list+'<td>'+item.birthdate+'</td>';
                        list = list+'<td>'+item.age+'</td>';
                    list = list+'</tr>';
                });
                $("#table tbody").append(list);
            }
            
        });

      }

      // NOTE : YOU CAN CREATE OTHER FUNCTION OR VARIABLE HERE


      ///////////////////////////
      //         END           //
      ///////////////////////////

</script>
</head>
<body onload="DoInitialize()">
<input type="hidden" id="totalpage" value="5" />
<input type="hidden" id="beforepage" value="0" />
<input type="hidden" id="afterpage" value="3" />
<input type="hidden" id="firstpage" value="TRUE" />
<input type="hidden" id="lastpage" value="FALSE" />
<span id="lblToday"></span>
<Table id="table">
	<thead>
        <tr>
            <th>NO</td>
            <th>ID</td>
            <th>NAME</td>
            <th>BIRTHDAY</td>
            <th>AGE</td>
        </tr>
    </thead>
    <tbody></tbody>
    <tfoot>
        <tr>
            <td colspan="5">
                <button onclick="btnFirst_Click()">First</button>
                <button onclick="btnPreviousPage_Click()">Previous Page</button>
                <button onclick="btnPrevious_Click()">Previous</button>
                <button onclick="btnNext_Click()">Next</button>
                <button onclick="btnNextPage_Click()">Next Page</button>
                <button onclick="btnLast_Click()">Last</button>
            </td>
        </tr>
    </tfoot>
<table>

</body>
</html> 