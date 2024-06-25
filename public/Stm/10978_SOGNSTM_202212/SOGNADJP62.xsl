<?xml version="1.0" encoding="Windows-874"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"   
xmlns:msxsl="urn:schemas-microsoft-com:xslt" 
xmlns:user="script:user">
<xsl:key name="keyRmkR" match="//Remarks/item" use="concat(@pathno,@rowid)"/>
<xsl:key name="keyRmkC" match="//Remarks/item" use="concat(@pahtno,@rowid,@colid)"/>

<xsl:template match="/STMADJP">
<xsl:comment>Last Update : 05-08-2019</xsl:comment>
<html>
<head>
<style>
	body {margin-top: 5pt; margin-left: 10pt; margin-right: 10pt  }
	p{font-family:Angsana New; font-size:14pt; align: left; margin-top: -12pt}
	th{font-family:Tahoma; font-size:9pt;  margin-top: -12pt;background-color: #99CCFF;}
	th.fst{font-family:Tahoma; font-size:9pt; margin-top: -12pt;background-color: #B9DCFF;}
	th.snd{font-family:Tahoma; font-size:9pt; margin-top: -12pt;background-color: #CEE7FF;}
	th.trd{font-family:Tahoma; font-size:9pt; margin-top: -12pt;background-color: #FFFFFF;}
	th.hd{font-family:Tahoma; font-size:9pt; margin-top: -12pt;background-color: #d2e9ff;}
	td{font-family:Tahoma; font-size:10pt; align: left; margin-top: -12pt}
	td.01{font-family:Tahoma; font-size:9pt; align: left; margin-top: -12pt;font-style: italic;}
	td.1{font-family:Tahoma; font-size:10pt; align: left; margin-top: -12pt;}
	td.spl{font-family:Tahoma; font-size:8pt; color: #808080 ; align: left; margin-top: -12pt}
	td.sum{font-family:Angsana New; font-size:14pt; align: left; margin-top: -14pt}
	td.sumh{font-family:Angsana New; font-size:15pt; align: left; margin-top: -14pt}
	td.sumn{font-family:Tahoma; font-size:10pt; align: left; margin-top: -14pt}
	td.main{font-family:Tahoma ; font-size:9pt; margin-top: -12pt; }
	td.remark{font-family:Tahoma; font-size:8pt; align: left; margin-top: 6pt}
	td.rmk{font-family:Tahoma; font-size:8pt; align: left; margin-top: 6pt;font-style: bold;}
	H3 {page-break-before: always}
	H4 {page-break-after: always}
	H5 {page-break-before: auto}
	thead th {
			position:relative;
			}
	thead {display: table-header-group; }
	hr.1 { margin-top: 0 pt; margin-bottom: 0 pt;   padding-top:  0 pt;    border-top: thin solid; color: #c8c8c8  }
	hr.2 { margin-top: 0 pt; margin-bottom: 0 pt;   padding-top:  0 pt;    border-top: thin dashed; color: #c8c8c8  }
</style>
<Style Type = "text/css" MEDIA = "print">
	.btprint{
	display:none;
	}
</Style>

<title><xsl:value-of select="ADJdoc"/>&#160;<xsl:value-of select="//ADJdoc/@desc"/></title>
</head>
<body >
<br></br>
<p><B><xsl:value-of select="config/STMheader/@desc"/></B></p>
<p  style="margin-top: -8pt">งวดวันที่ &#160;&#160;<xsl:value-of select="dateStart"/> &#160;&#160;ถึงวันที่ &#160;&#160;<xsl:value-of select="dateEnd"/></p>
<p style="margin-top: -14pt">เลขที่เอกสาร : <B><xsl:value-of select="ADJdoc"/></B>&#160;&#160;&#160;&#160;&#160;&#160;&#160;ออกโดย&#160;&#160;&#160;&#160;สำนักสารสนเทศบริการสุขภาพ&#160;&#160;&#160;&#160;<xsl:value-of select="dateIssue"/></p>
<p style="margin-top: -2pt"><B><xsl:value-of select="hname"/> &#160;&#160;(<xsl:value-of select="hcode"/>)</B></p>

<p style="margin-top: 2pt">
<hr width = '1240' size ='2pt'  align = 'left' noshade ='true'/>
<xsl:comment>Group DATA</xsl:comment>
<xsl:for-each select ='STMdat/dat'>
<xsl:variable name ='cSys' select ='//STMdat/@code'/>

<xsl:choose>
<xsl:when test="@code='B' and @type ='ADJ' ">
<table BORDER = "0" width = "1240" CELLSPACING = "0" cellpadding = "0">
<thead>
<tr height ='32pt' valign ='center'>
<td class ='sumh' valign ='bottom' colspan ='14'><B><xsl:value-of select="@name" /></B></td>
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
</thead>
<tbody>
<xsl:for-each select ='//ABills/ABill'>
<xsl:sort select="hn" order="ascending" />
<xsl:sort select="invno" order="ascending" />

<tr height='25pt'>
<td align='center'><xsl:value-of select ='position()'/></td>
<td align='center'><xsl:value-of select ='hcare'/></td>
<td align='center'><xsl:value-of select ='hmain'/></td>
<td><xsl:value-of select ='hn'/></td>
<td><xsl:value-of select ='invno'/></td>
<td><xsl:value-of select ='pid'/></td>
<td><xsl:value-of select ='name'/></td>
<td><xsl:value-of select="concat(substring(dttran,9,2),'/',substring(dttran,6,2),'/',substring(dttran,3,2)+43)" />&#160;<xsl:value-of select="concat(substring(dttran,12,2),'.', substring(dttran,15,2))" /></td>
<td align='center'><xsl:value-of select ='payplan'/></td>
<td align='center'><xsl:value-of select ='bp'/></td>
<td align='center'><xsl:value-of select ='bf'/></td>
<td align='center'><xsl:value-of select ='care'/></td>
<td align='center'><xsl:value-of select ='pcode'/></td>
<td align='center'><xsl:value-of select ='copay'/></td>
<td align ='right'><xsl:value-of select ='format-number(amount,"#,##0.00")'/>&#160;</td>
<td align='center'><xsl:value-of select ='stmid'/></td>
<td><xsl:value-of select ='cstat'/></td>
</tr>

</xsl:for-each> <!-- ABILLs-->

<tr><td colspan = "17"><hr  size = '1px'  /></td></tr>
<xsl:variable name ="sFclor">
<xsl:choose>
<xsl:when test ='total/@code ="M"'>#ff0000</xsl:when>
<xsl:otherwise>#000000</xsl:otherwise>
</xsl:choose>
</xsl:variable>

<tr height ='25pt'>
<td class ='sum' colspan ='5'><B>รวมรายการแก้ไข</B></td>
<td class ='sumn' align ='right'><B><xsl:value-of select ="format-number(count,'#,##0')"/></B>&#160;&#160;</td>
<td class ='sum'><B>&#160;รายการ</B></td>
<td colspan='2'></td>
<td class ='sumn' colspan ='6' align ='right'><B><font color='{$sFclor}'><xsl:value-of select ="format-number(total,'#,##0.00')"/></font></B>&#160;</td>
<td class ='sum'><B>&#160;บาท</B></td>
</tr>
<tr><td colspan = "17"><hr  size = '1px'  /></td></tr>

</tbody>
</table>

<xsl:call-template name="ShowRemarks">
	<xsl:with-param name="lstpath" select="1" />
</xsl:call-template>

</xsl:when>

<xsl:otherwise>

</xsl:otherwise>
</xsl:choose>
<br/>
<br/>
</xsl:for-each>
</p>
<br/>
<br/>




</body>
</html>
</xsl:template>

<xsl:template name="ShowRemarks">
<xsl:param name="lstpath" />


    <table  width = "1000" border ='0' cellspacing ='0' cellpadding ='0'>
	<xsl:for-each select ="//STMADJP/Remarks">
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

<xsl:template name="ShowRemarks-old">
<xsl:param name="lstpath" />
<table  width = "1000" border ='0' cellpadding ='0' cellspacing ='0' >
<tr>
<td width ='100'>&#160;</td>
<td width ='400'>&#160;</td>
<td width ='100'>&#160;</td>
<td width ='400'>&#160;</td>
</tr>
<xsl:for-each select ="//STMADJP/Remarks">
<tr height='20pt'>
<td  class ='remark'  colspan='4'>&#160;<xsl:value-of select= "@desc"/></td>
</tr>
<tr>
<td colspan='2'  valign='top'>
<table width ='495' border ='0' cellpadding ='0' cellspacing ='0'>
<xsl:for-each select ="item[@pathno=$lstpath and @colid =1]">
<xsl:variable name ='class1'>
<xsl:choose>
<xsl:when test ='@type="N"'>rmk</xsl:when>
<xsl:otherwise>remark</xsl:otherwise>
</xsl:choose>
</xsl:variable>
<tr height ='15pt'>
<td class ='{$class1}'  width ='100' align='right'><xsl:value-of select ='@code'/></td>
<td class ='remark'  width ='395'>&#160;&#160;&#160;<xsl:value-of select ='@desc'/></td>
</tr>
</xsl:for-each>
</table>
</td>
<td colspan ='2'  valign='top'>
<table width ='495' border ='0' cellpadding ='0' cellspacing ='0'>
<xsl:for-each select ="item[@pathno=$lstpath and @colid =2]">
<xsl:sort select ='@rowid'/>
<xsl:variable name ='class2'>
<xsl:choose>
<xsl:when test ='@type="N"'>rmk</xsl:when>
<xsl:otherwise>remark</xsl:otherwise>
</xsl:choose>
</xsl:variable>
<tr height ='15pt'>
<td class ='{$class2}' width ='100' align='right'><xsl:value-of select ='@code'/></td>
<td class ='remark' width ='395'>&#160;&#160;&#160;<xsl:value-of select ='@desc'/></td>
</tr>
</xsl:for-each>
</table>
</td>
</tr>
</xsl:for-each>
</table>

</xsl:template>

</xsl:stylesheet> 