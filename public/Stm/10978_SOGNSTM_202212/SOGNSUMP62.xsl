<?xml version="1.0" encoding="Windows-874"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"   
xmlns:msxsl="urn:schemas-microsoft-com:xslt" 
xmlns:user="script:user"
xmlns:fo="http://www.w3.org/1999/XSL/Format">
<xsl:template match="/"> 
<xsl:comment>Last Update : 2018-09-02</xsl:comment>
<html>
<head>
			<style>
				body {margin-top: 15pt; margin-left: 15pt; margin-right: 10pt; margin-top: 10pt }
				p{font-family:Angsana New; font-size:14pt; align: left; margin-top: -12pt}
				td{font-family:Angsana New; font-size:14pt; align: left; margin-top: -18pt; height: 12pt}
			</style>		

			<Style Type = "text/css" MEDIA = "screen">
				.ticketid{
				display:none;
				}
			</Style>
			<Style Type = "text/css" MEDIA = "print">
				.btprint{
				display:none;
				}
			</Style>
       <title><xsl:value-of select="//STMSUMP/stmno"/>&#160;<xsl:value-of select="//STMSUMP/stmno/@desc"/></title>	

   </head>
   <body >
   <p style="margin-left: 10pt">
   <table border = "0" width = "620" >
      <xsl:for-each select="STMSUMP/chi">
   <tr>
   <td height = "10"  width = "75" align ="center" rowspan = '3' > 
		                      <xsl:choose>
				      <xsl:when test = "image[.!='']">
		                      <xsl:element name = "IMG">
				      <xsl:attribute name = "SRC">
				      <xsl:value-of select="image"/>
				      </xsl:attribute>
				      </xsl:element>
    	                               </xsl:when>
				       <xsl:otherwise>
					n/a
		                       </xsl:otherwise>
				       </xsl:choose>
   </td>
   <td width = "10"></td>
   <td ><B>สำนักสารสนเทศบริการสุขภาพ</B></td>
   </tr>
   <tr>
    <td></td>
   <td ><font  size ="3pt">979/103-104 ชั้น 31 อาคารเอสเอ็มทาวน์เวอร์ ถ.พหลโยธิน  สามเสนใน  พญาไท  กรุงเทพฯ</font></td>
   </tr>
    <tr>
   <td></td>
   <td ><font  size ="3pt">โทร : 0-2298-0405-8  &#160;&#160;&#160;โทรสาร : 0-2298-0409 &#160;&#160;&#160; URL: http://www.chi.or.th</font></td>
   </tr>

   </xsl:for-each>
   </table>
   </p>

	<p style="margin-left: 15pt; margin-top: 10pt">
	<table border = "0"  width="620"  cellspacing = '0'  cellpadding = '0'> 
	<tr>
		<td  width ='85'>ที่</td>
		<td  colspan ='2'><xsl:value-of select="//STMSUMP/stmno"/></td>
	</tr>
	<tr>
		<td width ='85'></td>
		<td width ='270'></td>
		<td width ='255'>วันที่  &#160;&#160;<xsl:value-of select="//STMSUMP/dateIssue"/></td>
	</tr>
	<tr>
		<td  width ='85'>เรื่อง</td>
		<td  valign ='top'  colspan ='2'>แจ้งสรุปยอดการแจ้งค่าใข้จ่ายค่ารักษาพยาบาลของผู้ป่วยนอก - ระบบประกันสังคม</td>
	</tr>
	<tr>
		<td  width ='85'>เรียน</td>
		<td  colspan ='2'>ผู้อำนวยการ<xsl:value-of select="//STMSUMP/hname"/> &#160;(<xsl:value-of select="//STMSUMP/hcode"/>)</td>
	</tr>
	</table>
		<table border = "0"  width="620"  cellspacing = '0'  cellpadding = '0'> 
	<xsl:for-each select="//STMSUMP/atth/doc">
			
			<tr>
					<td  width ='85'>
					<xsl:if test ="@id=1"><xsl:value-of select="//STMSUMP/atth/@desc"/>
					</xsl:if>
					</td>
					<td colspan ='2'><xsl:value-of select="@desc"/><xsl:value-of select="."/></td>
			</tr>
	</xsl:for-each>
	</table>
	</p>
	<p style="margin-left: 15pt; margin-top:-10pt">
	<table   border = "0"  width="620" cellspacing = '0'  cellpadding = '0'> 
	<tr>
		<td width ='85'></td>
		<td width ='145'></td>
		<td width ='160'></td>
		<td width ='40'></td>
		<td width ='130'></td>
		<td width = '15'></td>
		<td width = '35' ></td>
	</tr>
	<tr>
		<td  width ='85'></td>
		<td colspan = '6' align = 'left'>สำนักสารสนเทศบริการสุขภาพ&#160;&#160;&#160;ขอส่งบัญชีรายการแจ้งค่าใช้จ่ายค่ารักษาพยาบาลผู้ป่วยระบบประกันสังคม</td>
	</tr>
	<tr>
		<td colspan = '7'>ประเภทผู้ป่วยนอก ของสถานพยาบาลท่าน</td>
	</tr>
	<tr>
		<td width ='85'></td>
		<td  colspan = '6'>ตั้งแต่วันที่ &#160;&#160;<xsl:value-of select="//STMSUMP/dateStart"/> &#160;&#160;&#160;ถึงวันที่ &#160;&#160;&#160;<xsl:value-of select="//STMSUMP/dateEnd"/></td>
	</tr>
	<tr>
		<td></td>
		<td colspan ='6'><HR/></td>
	</tr>
	<xsl:for-each select="//STMSUMP/STMdat">
	<tr>
		<td></td>
		<td colspan = '6'><B>สำหรับ<xsl:value-of select="@name"/>-<xsl:value-of select="@desc1"/></B></td>
	</tr>
	
	<tr>
		<td ></td>
		<td colspan = '6'>จำนวนสถานี &#160;&#160;&#160;<B><xsl:value-of select="tst"/></B>&#160;&#160;&#160; สถานี</td>
	</tr>
	<xsl:for-each select ='Dat'>
	<tr>
		<td ></td>
		<td><xsl:value-of select="@desc1"/></td>
		<td align ='right' ><xsl:value-of select='format-number(Tcount,"#,##0")'/></td>
		<td>&#160;&#160;ราย</td>
		<td></td>
		<td></td>
	</tr>

	<xsl:choose>
	<xsl:when test="Ttotal/@extra ='T'">
	<tr>
		<td></td>
		<td ><xsl:value-of select="@desc"/></td>
		<td align ='right' ><I><xsl:value-of select= 'format-number(Ttotal/@tt+TFeetotal, "#,##0.00")'/></I></td>
		<td>&#160;&#160;<I>บาท</I></td>
		<td ></td>
		<td></td>
		<td></td>
	</tr>
	<xsl:if test="Tcount/@bt>0">
	<tr>
		<td ></td>
		<td><xsl:value-of select="@desc2"/>&#160;&#160;[<I>&#160;<xsl:value-of select='format-number(Tcount/@bt,"#,##0")'/>&#160;&#160;ราย</I>&#160;]</td>
		<td  align ='right' ><I><xsl:value-of select= 'format-number(Ttotal/@bt, "#,##0.00")'/></I></td>
		<td>&#160;&#160;<I>บาท</I></td>
		<td ></td>
		<td></td>
		<td></td>
	</tr>
	</xsl:if>
	<xsl:if test="Tcount/@bb>0">
	<tr>
		<td ></td>
		<td ><xsl:value-of select="@desc3"/>&#160;&#160;[<I>&#160;<xsl:value-of select='format-number(Tcount/@bb,"#,##0")'/>&#160;&#160;ราย</I>&#160;]</td>
		<td  align ='right' ><I><xsl:value-of select= 'format-number(Ttotal/@bb, "#,##0.00")'/></I></td>
		<td >&#160;&#160;<I>บาท</I></td>
		<td ></td>
		<td></td>
		<td></td>
	</tr>
	</xsl:if>
	</xsl:when>
	<xsl:otherwise>

	</xsl:otherwise>
	</xsl:choose>
	<tr>
		<td ></td>
		<td><xsl:value-of select ="Tamount/@desc"/></td>
		<td></td>
		<td></td>
		<td align ='right' ><xsl:value-of select= 'format-number(Tamount, "#,##0.00")'/></td>
		<td></td>
		<td> บาท</td>
	</tr>

	</xsl:for-each><xsl:comment>end of Dat</xsl:comment>
	<tr>
		<td></td>
		<td colspan ='6'><HR/></td>
	</tr>
	</xsl:for-each>

	<!-->
	<tr>
		<td></td>
		<td><B>จำนวนรายการทั้งสิ้น</B></td>
		<td></td>
		<td></td>
		<td align ='right'><B><xsl:value-of select= 'format-number(//STMSUMP/acount, "#,##0")'/></B></td>
		<td></td>
		<td><B>ราย</B></td>
	</tr>
	<!-->

	<tr>
		<td></td>
		<td><B>รวมยอดแจ้งค่าใช้จ่ายทั้งสิ้น</B></td>
		<td></td>
		<td></td>
		<td align ='right'><B><xsl:value-of select= 'format-number(//STMSUMP/amount, "#,##0.00")'/></B></td>
		<td></td>
		<td><B>บาท</B></td>
	</tr>
	<tr>
		<td></td>
		<td colspan='6' align = 'right'><B>(<xsl:value-of select="//STMSUMP/thamount"/>)</B></td>
	</tr>
	<tr>
		<td></td>
		<td colspan ='6'><HR/></td>
	</tr>
	<tr>
		<td></td>
		<td  colspan ='6'>ตามรายละเอียดที่ปรากฏในเอกสารแนบ (หรือ) แสดงรายการตามขั้นตอนที่กำหนดไว้ต่อไป </td>
	</tr>
	<tr>
		<td  colspan ='7'>หากพบข้อมูลผิดพลาดหรือต้องการแก้ไข&#160;โปรดแจ้งสำนักสารสนเทศบริการสุขภาพ&#160;&#160;ภายในวันที่&#160;<xsl:value-of select="//STMSUMP/dateDue"/></td>
	</tr>

	</table>
	</p>
	<p style="margin-left: 15pt; margin-top:2pt">
	<table   border = "0"  width="620" > 
	<tr>
		<td width = '260'></td>
		<td width = '380' align ='center'>ขอแสดงความนับถือ</td>
		<td width = '70'></td>
	</tr>
	<tr>
		<td ></td>
		<td  align ='center'><br></br>นายสุเมธี   เชยประเสริฐ</td>
		<td ></td>
	</tr>
	<tr>
		<td ></td>
		<td  align ='center'>ผู้จัดการสำนักสารสนเทศบริการสุขภาพ</td>
		<td ></td>
	</tr>
	<tr>
		<td > </td>
		<td ></td>
		<td ></td>
	</tr>
	</table>
	</p>
	<p style="margin-left: 20pt; margin-top: 30pt">
		<DIV class = "Ticketid">
			<B><xsl:value-of select="STMSUMP/ticket/id"/></B>
		</DIV>
	</p>
   </body>
   </html>
</xsl:template>
</xsl:stylesheet> 