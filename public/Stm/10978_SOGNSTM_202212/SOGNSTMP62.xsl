<?xml version="1.0" encoding="Windows-874"?>
<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"   
xmlns:msxsl="urn:schemas-microsoft-com:xslt" 
xmlns:user="script:user">
<xsl:template match="/STMSTMP">
<xsl:comment>Last Update : 05-08-2019</xsl:comment>
<html>
<head>
<style type="text/css">
	body {margin-top: 5pt; margin-left: 20pt; margin-right: 10pt  }
	p{font-family:Angsana New; font-size:14pt; align: left; margin-top: -12pt}
	th{font-family:Tahoma; font-size:9pt; margin-top: -12pt;}
	td{font-family:Tahoma; font-size: 9pt; align: left; margin-top: -12pt}
	td.Amb{font-family:Tahoma; font-size:9pt; align: left; margin-top: -12pt;background-color: #99CCFF;}
	td.Amb2{font-family:Tahoma; font-size:9pt; align: left; margin-top: -12pt;background-color: #D7E6FD;}
	td.sum{font-family:Angsana New; font-size:14pt; align: left; margin-top: -16pt; padding-bottom: 0 pt}
	td.sumsup{font-family:Angsana New;font-size:10pt; padding-top: 0 pt; margin-top: -16pt}
	td.remark{font-family:Tahoma; font-size:8pt; align: left; margin-top: -6pt}

	sup{font-family:Angsana New; font-size:8pt}
	H3 {page-break-before: always}
	H4 {page-break-after: always}
	H5 {page-break-before: auto}
	thead th {
		position:relative;
	}
	thead {display: table-header-group; }
	hr.1 { margin-top: 3 pt; margin-bottom: 0 pt;   padding-top:  0 pt;    border-top: thin dotted; color: gray  }
</style>
<Style Type = "text/css" MEDIA = "screen">
	.tbrmk{
	display:none;
	}
</Style>
<Style Type = "text/css" MEDIA = "print">
	.shwrmk{
	display:none;
	}
</Style>
<title><xsl:value-of select="//STMdoc"/>&#160;<xsl:value-of select="//STMdoc/@desc"/></title>	
</head>
<body >
	<br></br>
	<p><B>บัญชีรายการแจ้งค่าใช้จ่ายค่ารักษาพยาบาลผู้ป่วยนอก - ระบบประกันสังคม</B></p>
	<p  style="margin-top: -8pt">งวดวันที่ &#160;&#160;<xsl:value-of select="//dateStart"/>&#160;&#160; ถึงวันที่ &#160;&#160;
	<xsl:value-of select="//dateEnd"/></p>
	<p style="margin-top: -2pt"><B><xsl:value-of select="hname"/>&#160;&#160;(<xsl:value-of select="hcode"/>)</B></p>
	<p style="margin-top: -10pt">เลขที่เอกสาร : <B><xsl:value-of select="//STMdoc"/></B></p>
	<p style="margin-top: -10pt">จำนวนสถานีทั้งสิ้น &#160;&#160;&#160;&#160;&#160;<B><xsl:value-of select="gst"/></B>&#160;&#160;&#160;&#160;สถานี &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;รวมยอดแจ้งค่าใช้จ่ายทั้งสิ้น &#160;&#160;&#160;&#160;&#160;<B>
	<xsl:value-of select='format-number(amount,"#,##0.00")'/></B>&#160;&#160;&#160;บาท<br/>
	<hr width = '1230pt' size ='2pt'  align = 'left' noshade ='true'/>
	
	</p>

	<xsl:comment>New Method</xsl:comment>
	<p style="margin-top: -12pt">
	<br/>
		<xsl:for-each select ="STMdat">
		<xsl:variable name ='cSys' select ='@code'/>
		<xsl:variable name ='cExtSrv' select ='@desc'/>
		<table width = '1230' border = '0' cellspacing = '0'  cellpadding = '0'>
		<tr>
		        <td  CLASS = "sum" colspan = '4'><font color='000099'><xsl:value-of select="@name"/>&#160;-&#160;<B>
			<xsl:value-of select="@desc1"/></B></font></td>
			<td  CLASS = "sum"  align = 'right' ><B><xsl:value-of select="tst"/></B>&#160; &#160;</td>
			<td  CLASS = "sum"  align = 'right' >สถานี</td>
			
		</tr>
		<xsl:for-each select ='Dat'>
		<tr>
			<td CLASS = "sum"  width = '420'><xsl:value-of select ="@desc1"/></td>
			<td CLASS = "sum" width = '190' align = 'right'><xsl:value-of select='format-number(Tcount,"#,##0")'/>&#160; &#160;</td>
			<td CLASS = "sum" width = '50' align = 'center'> ราย </td>
			<td CLASS = "sum" width = '240'>&#160; &#160;<xsl:value-of select ="@desc"/></td>
			<td CLASS = "sum" width = '270' align = 'right' ><xsl:value-of select='format-number(Tamount,"#,##0.00")'/>&#160; &#160;</td>
			<td CLASS = "sum" width = '60' align = 'right'> บาท</td>
		</tr>
		<xsl:if test ='@type="A"'>
		<xsl:variable name = 'aid' select ='@type'/>
		<tr>
			<td CLASS = "sumsup" colspan = '6' ><i><xsl:value-of select ="@desc2"/>&#160; &#160;<xsl:value-of select="//STMSTM/rel/doc[@id=$aid]"/></i></td>
		</tr>
		</xsl:if>
		</xsl:for-each>
		<tr >
			<td CLASS = "sum"  colspan ='4' >รวมยอดแจ้งค่าใช้จ่าย<xsl:value-of select="@desc2"/>ทั้งสิ้น </td>
			<td CLASS = "sum" align = 'right' ><xsl:value-of select='format-number(Gtotal,"#,##0.00")'/>&#160; &#160;</td>
			<td CLASS = "sum" align = 'right'> บาท</td>
		</tr>
	
		<tr>
			<td colspan = '6'> <hr class= "1"/></td>
		</tr>
		
		</table>
	
		<H4>

		<xsl:for-each select ="//TBills[@code = $cSys]/ST">
		<xsl:variable name="stname"><xsl:value-of select="@name" /></xsl:variable>
		 <xsl:variable name="stTcase"  select='@Tcase' />	 
		<xsl:variable name="stTamt"  select='@Tamt' />	 
		<xsl:variable name="stHcase" select="@Hcase"/>	 
		<xsl:variable name="stHamt" select='@Hamt'/>	 

		<table BORDER = "0" width = "{//Remarks/tables/table[@code=$cSys]/@width}" CELLSPACING = "0" cellpadding = "0">
		<thead >	
		<tr>
		<td   colspan = "8">
		<font color = '#0033CC'><B><I>สถานี :&#160;<xsl:value-of select="$stname" />&#160;&#160;&#160;&#160;<xsl:value-of select="$cExtSrv"/></I></B></font>
		</td>
		</tr>
		<xsl:comment>Start : ShowHeader</xsl:comment>			
		   <xsl:for-each select ="//Remarks/tables/table[@code=$cSys]">
			<xsl:for-each select ='Row[@type ="H"]'>
			<xsl:sort select ="@id"/>
			   <tr  bgcolor ="{@rbgcolor}" height ="{@height}">
				<xsl:for-each select ="column">
				  <xsl:sort select ="@id"/>
					<th  class ="{@class}" colspan = "{@span}" width ="{@width}" style="{@style}"  align ="{@align}" valign ="{@valign}"><xsl:value-of select="@caption"/></th>
				</xsl:for-each>
			    </tr>
			</xsl:for-each>
			<tr valign ='center' height ='10pt'><td colspan = "{@col}"><hr  size = '1pt' /></td></tr>
		   </xsl:for-each>
		<xsl:comment>End : ShowHeader</xsl:comment>
		</thead >	
		<tbody>
		<xsl:for-each select ="HG">
			<xsl:if test ="@flg ='Y'">
			<!-->empty 1 line<!-->
			<tr height ='10pt'>
			<td>&#160;</td>
			</tr>
			</xsl:if>

		<!-->showdata<!-->
			<xsl:for-each select = "TBill">
			 <xsl:variable name="nn"><xsl:value-of select="string-length(name)" /></xsl:variable>
			  <tr height ='20pt' valign ='top'>
			  <td><xsl:value-of select="sys/@id" /></td>
			  <!-->  <td><xsl:number  format="1" /></td><!-->
			  <td><xsl:value-of select="hcare" /></td>
			  <td><xsl:value-of select="hmain" /></td>
			  <td><xsl:value-of select="hn" /></td>
			  <td><xsl:value-of select="invno" /></td>
			  <td><xsl:value-of select="pid" /></td>
			  <td>
			  <xsl:choose>
			  <xsl:when test ="$nn = 0">&#160;&#160;&#160;-</xsl:when> 
			  <xsl:otherwise><xsl:value-of select="name" /></xsl:otherwise>
			  </xsl:choose>
			  </td>
			  <td ><xsl:value-of select="concat(substring(dttran,9,2),'/',substring(dttran,6,2),'/',substring(dttran,3,2)+43)" />&#160;<xsl:value-of select="concat(substring(dttran,12,2),'.', substring(dttran,15,2))" /></td>
			  <td align='center'><xsl:value-of select="payplan" /></td>	
			  <td align='center'><xsl:value-of select="bp" /></td>	
			  <td align='center'><xsl:value-of select="bf" /></td>	
			  <td align='center'><xsl:value-of select="care" /></td>	
			  <td align='center'><xsl:value-of select="pcode" /></td>	
			  <td align='center'><xsl:value-of select="rid" /></td>	
			  <td align ='center'><xsl:value-of select="copay" /></td>
			  <td colspan="1" align = "right">
			  <xsl:value-of select='format-number(total,"#,##0.00")' />
			  </td>
			  <td align = 'center' ><xsl:value-of select="cstat" /></td>
			  </tr>	
			<xsl:if test="cfh != '' ">
			<tr height ='20pt'  valign="top">
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td colspan = '10'><font color="#008000"><I><xsl:value-of select="cfh/@desc"/></I></font></td>
			</tr>
			</xsl:if>
		</xsl:for-each>
		</xsl:for-each>
		</tbody>
		<xsl:comment>Summary</xsl:comment>
		<tr><td colspan = "{//Remarks/tables/table[@code=$cSys]/@col}"><hr noshade ='true'/></td></tr>
		<tr height ='22pt'>
			<td colspan = "{//Remarks/tables/table[@code=$cSys]/@scol}"><B>รวมยอดค่าใช้จ่ายค่ารักษาพยาบาล</B></td>
			<td  align ='right'><B><xsl:value-of select='format-number($stTcase,"#,##0")' /></B></td>
			<td><B>&#160;&#160;&#160;ราย</B></td>
			<td></td>
			<td  colspan ='8' align = "right" ><B><xsl:value-of select='format-number($stTamt,"#,##0.00")' /></B></td>
			<td>&#160;&#160;<B>บาท</B></td>
		</tr>
		<xsl:if test ="$stHcase>0">
		<tr>
			<td colspan = "{//Remarks/tables/table[@code=$cSys]/@scol}"><B><font color = '#555555'>รวมกันไว้</font></B></td>
			<td  align ='right'><B><font color = '#555555'><xsl:value-of select='format-number($stHcase,"#,##0")' /></font></B></td>
			<td><B><font color = '#555555'>&#160;&#160;&#160;ราย</font></B></td>
			<td  colspan ='4' align = "right" ><B><font color = '#555555'><xsl:value-of select='format-number($stHamt,"#,##0.00")' /></font></B></td>
			<td>&#160;&#160;<B>บาท</B></td>
		</tr>
		</xsl:if>
		<tr><td colspan = "{//Remarks/tables/table[@code=$cSys]/@col}"><hr noshade ='true'/></td></tr>
		<tr><td colspan = "{//Remarks/tables/table[@code=$cSys]/@col}">&#160;</td></tr>
		<xsl:comment>End - Summary</xsl:comment>
		</table>

		<div class ='tbrmk'>
		<xsl:call-template name="ShowRemarks">
		<xsl:with-param name="lstpath" select="$cSys" />
		</xsl:call-template>
		</div>

		</xsl:for-each> <!-->end of TBills/ST<!-->


		<DIV class = "shwrmk">
		<xsl:call-template name="ShowRemarks">
		<xsl:with-param name="lstpath" select="$cSys" />
		</xsl:call-template>
		</DIV>
		</H4>
		</xsl:for-each> <!-- [End of table ] -->





</p>
</body>
</html>
</xsl:template>




<xsl:template name="ShowHeader">
<xsl:param name="lstsys"/>
<xsl:comment>
	***เรียกโครงสร้างจาก Data***
</xsl:comment>
   <xsl:for-each select ="//Remarks/tables/table[@code=$lstsys]">
   	<xsl:for-each select ='Row[@type ="H"]'>
	<xsl:sort select ="@id"/>
	   <tr  bgcolor ="{@rbgcolor}" height ="{@height}">
		<xsl:for-each select ="column">
		  <xsl:sort select ="@id"/>
			<th  class ="{@class}" colspan = "{@span}" width ="{@width}" style="{@style}"  align ="{@align}" valign ="{@valign}"><xsl:value-of select="@caption"/></th>
		</xsl:for-each>
	    </tr>
	</xsl:for-each>
	<tr><td colspan = "19"><hr  size = '1pt' /></td></tr>
   </xsl:for-each>

</xsl:template>


<xsl:template name="ShowRemarks">
<xsl:param name="lstpath" />


    <table  width = "1000" border ='0' cellspacing ='0' cellpadding ='0'>
	<xsl:for-each select ="//STMSTMP/Remarks">
	<tr height ='25pt'>
	<td colspan='2'><B><xsl:value-of select= "@desc"/></B></td>
	</tr>
	<tr valign='top'>
	<td width ='500'>
	    <table  width = "450" border ='0' cellspacing ='0' cellpadding ='0'>
		<xsl:for-each select ="item[@pathno=$lstpath and @coln = 1]">
		<tr valign ='top'  height ='18pt'>
		<td class ='remark' width='120' align ='right'><B><xsl:value-of select= "@code"/></B>&#160;&#160;</td>
		<td class ='remark' width='330' >&#160;<xsl:value-of select= "@desc"/></td>
		</tr>
		</xsl:for-each>
	    </table>
	</td>
	<td width ='500'>
	    <table  width = "450" border ='0' cellspacing ='0' cellpadding ='0'>
		<xsl:for-each select ="item[@pathno=$lstpath and @coln = 2]">
		<tr valign ='top'  height ='18pt'>
		<td class ='remark' width='120' align ='right'><B><xsl:value-of select= "@code"/></B>&#160;&#160;</td>
		<td class ='remark' width='330' >&#160;<xsl:value-of select= "@desc"/></td>
		</tr>
		</xsl:for-each>
	    </table>
	</td>
	</tr>
    </xsl:for-each>  
    </table>

</xsl:template>

</xsl:stylesheet> 