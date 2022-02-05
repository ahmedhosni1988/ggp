<?php

function template_edit_order()
{

    global $lang, $account_contact, $services, $pack, $tran, $pay, $allacc, $addser, $check, $sett, $zone, $com, $order_details, $vechile_service, $addtinal_service, $order_packages, $mprice, $drivers, $addprice, $vecprice, $fuelsurge, $dri_ser, $sett_compnay, $order_skid, $c_setting;

    echo '
	
	
<script type="text/javascript" src="' . SITEURL . '/' . STYLE . '/jscript/montior.js" ></script>
	
	
	
<form name="edit_orderss" id="edit_orderss_' . $order_details->order_id . '"  method="post" action="' . SITEURL . '/administrator/montior.php?action=edit_detailsorder" class="form-horizontal" role="form">
<input type="hidden" name="is_edit_order" value="1" />
<input type="hidden" name="order_id" value="' . $order_details->order_id . '" />
<input type="hidden" name="account_id" value="' . $order_details->account_id . '" />
	
		
		<table border="0" cellspacing="1" cellpadding="0"> 
<tbody><tr>
<td valign="top">
<table border="1"><tbody><tr><td><table border="0" cellpadding="0">
<tbody>
		<tr>
		<td bgcolor="dddddd" align="left">
		<font face="verdana" size="2">
		<b>' . $lang[279] . '</b>
		</font>
		</td>
		<td colspan="8" bgcolor="eeeeee">
				<font face="verdana" size="2">' . $order_details->account_name . ' | ' . $order_details->account_company . '</font>
		</td>
		</tr>
						
<tr><td bgcolor="eeeeee" colspan="9">
      <font size="2" color="blue">
      <a href="#bottom" style="text-decoration: none">
      <u>bottom of page</u> </a>
      </font>
      <font size="3"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <b> ' . $lang[282] . ' </b>
      </font>
      </td> </tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Name</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="from_name" tabindex="1" onfocus="highlight(event);" value="OMS-PDL Local" size="30" style="background-color: rgb(255, 255, 224);"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Address</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><textarea name="from_addr" tabindex="2" onfocus="highlight(event);" rows="2" cols="30">1100 Algoma</textarea></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Postal
code</font></td><td align="left" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="from_pc" tabindex="3" onfocus="highlight(event);" value="" size="11"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">Zone</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><select name="from_zone" tabindex="4"><option> </option><option>01</option>
<option>03</option>
<option>04</option>
<option>05</option>
<option>06</option>
<option>07</option>
<option>08</option>
<option>09</option>
<option>10</option>
<option>11</option>
<option>12</option>
<option>13</option>
<option selected="">14</option>
<option>15</option>
<option>16</option>
<option>17</option>
<option>18</option>
<option>19</option>
<option>20</option>
<option>21</option>
<option>22</option>
<option>23</option>
<option>24</option>
<option>25</option>
<option>26</option>
<option>27</option>
<option>28</option>
<option>29</option>
<option>30</option>
<option>31</option>
<option>32</option>
<option>33</option>
<option>34</option>
<option>35</option>
<option>36</option>
<option>37</option>
<option>38</option>
<option>39</option>
<option>40</option>
<option>41</option>
<option>42</option>
<option>43</option>
<option>44</option>
<option>45</option>
<option>46</option>
<option>47</option>
<option>48</option>
<option>49</option>
<option>50</option>
<option>51</option>
<option>52</option>
<option>53</option>
<option>54</option>
<option>60</option>
</select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Phone</font></td><td align="left" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="from_phone" tabindex="5" onfocus="highlight(event);" value="" size="11"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">Contact</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="from_contact" tabindex="6" onfocus="highlight(event);" value="OMS Dispatch" size="10"></font></td></tr>
<tr><td align="left" rowspan="2" bgcolor="dddddd"><font face="verdana" size="2">Pickup<br><input type="text" name="pickup_date" tabindex="8" onfocus="highlight(event);" value="2015-07-10" size="9" onchange="Javascript:updatepickupday(document.statusfullform.pickup_date.value)"></font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="radio" tabindex="8" name="pickup_by" onfocus="highlight(event);" value="1"></font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2">before</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="radio" tabindex="8" name="pickup_by" onfocus="highlight(event);" value="2"></font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2">after</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="radio" tabindex="8" name="pickup_by" onfocus="highlight(event);" value="3"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2">at</font></td></tr>
<tr><td align="left" colspan="3" bgcolor="ffffff"><font face="verdana" size="2"><select name="pickup_day" tabindex="9" onchange="Javascript:PickupDay(this.value)"> <option selected="" value="0">Today</option><option value="1">Sat</option><option value="2">Sun</option><option value="3">Mon</option><option value="4">Tue</option><option value="5">Wed</option><option value="6">Thu</option><option value="7">Fri</option></select></font></td><td align="left" colspan="3" bgcolor="ffffff"><font face="verdana" size="2"><select name="pickup_time" tabindex="10"> <option selected="">     </option><option> 1:00</option><option> 1:15</option><option> 1:30</option><option> 1:45</option><option> 2:00</option><option> 2:15</option><option> 2:30</option><option> 2:45</option><option> 3:00</option><option> 3:15</option><option> 3:30</option><option> 3:45</option><option> 4:00</option><option> 4:15</option><option> 4:30</option><option> 4:45</option><option> 5:00</option><option> 5:15</option><option> 5:30</option><option> 5:45</option><option> 6:00</option><option> 6:15</option><option> 6:30</option><option> 6:45</option><option> 7:00</option><option> 7:15</option><option> 7:30</option><option> 7:45</option><option> 8:00</option><option> 8:15</option><option> 8:30</option><option> 8:45</option><option> 9:00</option><option> 9:15</option><option> 9:30</option><option> 9:45</option><option>10:00</option><option>10:15</option><option>10:30</option><option>10:45</option><option>11:00</option><option>11:15</option><option>11:30</option><option>11:45</option><option>12:00</option><option>12:15</option><option>12:30</option><option>12:45</option></select></font></td><td align="left" colspan="2" bgcolor="ffffff"><font face="verdana" size="2"><select name="pickup_ampm" tabindex="11"><option></option><option selected="">AM</option><option>PM</option></select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Comments</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><textarea name="comments" tabindex="12" onfocus="highlight(event);" rows="2" cols="30"></textarea></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Delivery<br>confirmation&nbsp;<br>email </font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="confemail" tabindex="13" onfocus="highlight(event);" value="" size="40"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Ordered by</font></td><td align="left" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="orderedby" tabindex="14" onfocus="highlight(event);" value="annick" size="11"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">Declared</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="declared_value" tabindex="15" onfocus="highlight(event);" value="" size="10"></font></td></tr>
<input type="hidden" name="ordersrc" value="A"><tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Entered by</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2">Admin:JC</font></td></tr>
<tr><td> </td></tr><tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Service</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><select name="service" tabindex="15"><option>Direct (ASAP)</option><option>60 Minute</option><option selected="">Rush (2 hours)</option><option>Sameday / Regular</option><option>Econo 24 Hour</option><option>OT Freight Service</option></select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Order Status</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><select name="laststatus" tabindex="17"><option value="3">In Progress (current status)
</option><option value="1">Pending
</option><option value="2">Completed
</option><option value="4">Cancel Requested
</option><option value="5">Cancelled
</option></select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Ordered </font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><font size="-3">Y-M-D</font></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="orderedyr" tabindex="21" onfocus="highlight(event);" value="2015" size="3"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="orderedmo" tabindex="22" onfocus="highlight(event);" value="07" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ordereddy" tabindex="23" onfocus="highlight(event);" value="10" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><font size="-3">H-M</font></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="orderedhh" tabindex="24" onfocus="highlight(event);" value="02" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="orderedmm" tabindex="25" onfocus="highlight(event);" value="43" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><select name="orderedampm" tabindex="26"><option>AM</option><option selected="">PM</option></select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Picked-up</font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><font size="-3">Y-M-D</font></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="pickedupyr" tabindex="31" onfocus="highlight(event);" value="2015" size="3"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="pickedupmo" tabindex="32" onfocus="highlight(event);" value="07" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="pickedupdy" tabindex="33" onfocus="highlight(event);" value="10" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><font size="-3">H-M</font></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="pickeduphh" tabindex="34" onfocus="highlight(event);" value="" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="pickedupmm" tabindex="35" onfocus="highlight(event);" value="" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><select name="pickedupampm" tabindex="36"><option selected="">AM</option><option>PM</option></select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Delivered</font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><font size="-3">Y-M-D</font></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="deliveredyr" tabindex="41" onfocus="highlight(event);" value="2015" size="3"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="deliveredmo" tabindex="42" onfocus="highlight(event);" value="07" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="delivereddy" tabindex="43" onfocus="highlight(event);" value="10" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><font size="-3">H-M</font></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="deliveredhh" tabindex="44" onfocus="highlight(event);" value="" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="deliveredmm" tabindex="45" onfocus="highlight(event);" value="" size="1"></font></td><td align="left" bgcolor="eeeeee"><font face="verdana" size="2"><select name="deliveredampm" tabindex="46"><option selected="">AM</option><option>PM</option></select></font></td></tr>
<input type="hidden" name="returnedyr" value="2015"><input type="hidden" name="returnedmo" value="07"><input type="hidden" name="returneddy" value="10"><input type="hidden" name="returnedhh" value=""><input type="hidden" name="returnedmm" value=""><tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">P.o.D</font></td><td colspan="4" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="pod" tabindex="50" onfocus="highlight(event);" value="" size="20"></font></td><td colspan="4" bgcolor="eeeeee"><font face="verdana" size="2">P.o.P&nbsp;<input type="text" name="pop" tabindex="51" onfocus="highlight(event);" value="" size="12"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Dispatch notes</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><textarea name="dnotes" tabindex="51" onfocus="highlight(event);" rows="2" cols="30"></textarea></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Non delivery notes</font></td><td colspan="8" bgcolor="eeeeee"><font face="verdana" size="2"><textarea name="ndnotes" tabindex="51" onfocus="highlight(event);" rows="2" cols="30"></textarea></font></td></tr>
</tbody></table></td></tr></tbody></table>
<p align="left">Note: Ordered, Picked-up and Delivered date-times are set when the order is entered,
      put in-progress and set to Complete.<br>
      If you need to change any, do so here.</p><p align="center"><input type="submit" tabindex="150" value="&nbsp;&nbsp;Save&nbsp;&nbsp;" style="font-weight:bold; font-size:14; color:white; font-family:Comic Sans Ms; background:#A0A0A0">&nbsp;&nbsp;<input type="button" tabindex="151" value="&nbsp;Exit&nbsp;" onclick="window.close();" style="font-weight:bold;
                      font-size:14;
                      color:white;
                      font-family:Comic Sans Ms; background:#A0A0A0">&nbsp;&nbsp;<input type="button" tabindex="152" value="Print Waybill" onclick="document.location.href=\'waybill.php?clid=34&amp;acctno=415&amp;uid=0&amp;wr=y&amp;ordernum=2171111\'" style="font-weight:bold;
                     font-size:14;
                     color:white;
                     font-family:Comic Sans Ms; background:#A0A0A0"></p><table border="1"><tbody><tr><td><table border="0" cellpadding="0">
<tbody><tr><td align="left" bgcolor="dddddd" colspan="2"><font face="verdana" size="2"><b>Driver</b></font></td><td align="center" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><select name="drivernum" tabindex="130"><option> Select driver </option><option>001 | Tom Burant
</option><option>002 | OMG Office
</option><option selected="">010 | Ibrahim Mackie
</option><option>013 | Olga Luvsandorzh
</option><option>020 | Michael Staughton
</option><option>030 | Louis Mihaly
</option><option>049 | Blair Pitters
</option><option>054 | Matt McMahon 
</option><option>077 | James Chappell
</option><option>086 | Ahmedjazz
</option><option>100 | Bob Millar  
</option><option>105 | Frank Francis
</option><option>128 | Andrej Kazancev
</option><option>140 | Michael Gravel
</option><option>222 | Joe Markell
</option><option>444 | Gary Thibert
</option><option>566 | Alan Smith
</option><option>899 | Pending &amp; Next day
</option><option>950 | Virtuel - OT
</option><option>CC011 | Gary Watson Cycling
</option><option>CP-OMG | 
</option><option>OT018 | Ryan 219-5921
</option><option>OT018RC | Ryan Craig (Evenings)
</option><option>OT077 | JC
</option><option>OT099 | Alma Burant
</option><option>OT128 | Andrej Kazancev
</option><option>OT158 | Mohammad Siage
</option><option>OT435 | Teresa Lacroix
</option><option>OT566 | Al Smith
</option><option>PBO | Prescheds - For billing only.
</option><option>Prescheds | 
</option><option>PS100 | Bob Millar - Misc Runs
</option></select></font></td></tr>
<tr><td align="left" bgcolor="dddddd"><font face="verdana" size="2">Commission </font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2"> % </font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2">Override %</font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2">&nbsp;&nbsp;&nbsp; Amount &nbsp;&nbsp;&nbsp;</font></td></tr>
<tr><td align="left" bgcolor="dddddd"><font face="verdana" size="2">Service:<br>Rush (2 hours)</font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2"><b>58</b></font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_commission_svc_pct" tabindex="131" onfocus="highlight(event);" value="" size="6"></font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2">8.49</font></td></tr>
<tr><td align="left" bgcolor="dddddd"><font face="verdana" size="2">Wait time </font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2"><b>50</b></font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_commission_wait_pct" tabindex="132" onfocus="highlight(event);" value="" size="6"></font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2">0.00</font></td></tr>
<tr><td align="left" bgcolor="dddddd"><font face="verdana" size="2">Additional </font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2"><b>50</b></font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_commission_xtra_pct" tabindex="133" onfocus="highlight(event);" value="" size="6"></font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2">0.00</font></td></tr>
<tr><td align="left" bgcolor="dddddd"><font face="verdana" size="2">Fuel surcharge</font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2"><b>75</b></font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_commission_fs_pct" tabindex="134" onfocus="highlight(event);" value="" size="6"></font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2">0.66</font></td></tr>
<tr><td align="left" bgcolor="dddddd"><font face="verdana" size="2">Adjustment </font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2">&nbsp;</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="commission_adj_desc" tabindex="135" onfocus="highlight(event);" value="" size="12"></font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="commission_adj" tabindex="136" onfocus="highlight(event);" value="0.00" size="6"></font></td></tr>
<tr><td align="left" bgcolor="dddddd"><font face="verdana" size="2">Total pay </font></td><td align="center" bgcolor="dddddd"><font face="verdana" size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2">&nbsp;</font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2">9.15</font></td></tr>
</tbody></table></td></tr></tbody></table>
<p align="left"><a name="bottom"></a> <br>Note: to override the commission % with zero, enter 0, Not Blank. Blank
      indicates No Override, and the drivers regular commission will apply.<br>
      Important: If you change drivers, be sure to remove the override%\'s if you
      want the normal commission %\'s from the new driver to be applied.<br>
      If you make any driver or commission changes, click <i>Save</i> and then
      return (here) to <i>Detailed View</i> to see re-calculated totals. </p><font size="2" color="blue">
       <a href="#top" style="text-decoration: none">
       <u><center><br><br> top of page </center></u> </a>
       </font></td>
<td valign="top">
<table border="1"><tbody><tr><td><table border="0" cellpadding="0">
<tbody><tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2"><b>Order no.</b></font></td><td colspan="6" bgcolor="eeeeee"><font face="verdana" size="2">2171111</font></td></tr>
<tr><td bgcolor="eeeeee" colspan="7">
      <font size="2" color="blue">
      <a href="#bottom" style="text-decoration: none">
      <u>bottom of page</u> </a>
      </font>
      <font size="3"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <b> To </b>
      </font>
      </td> </tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Name</font></td><td colspan="6" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="to_name" tabindex="60" onfocus="highlight(event);" value="" size="30"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Address</font></td><td colspan="6" bgcolor="eeeeee"><font face="verdana" size="2"><textarea name="to_addr" tabindex="61" onfocus="highlight(event);" rows="2" cols="30">2018 robertson</textarea></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Postal
code</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="to_pc" tabindex="62" onfocus="highlight(event);" value="" size="11"></font></td><td align="center" colspan="2" bgcolor="dddddd"><font face="verdana" size="2">Zone</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><select name="to_zone" tabindex="63"><option> </option><option>01</option>
<option>03</option>
<option>04</option>
<option>05</option>
<option>06</option>
<option>07</option>
<option>08</option>
<option>09</option>
<option>10</option>
<option>11</option>
<option>12</option>
<option>13</option>
<option>14</option>
<option>15</option>
<option>16</option>
<option>17</option>
<option>18</option>
<option>19</option>
<option>20</option>
<option>21</option>
<option selected="">22</option>
<option>23</option>
<option>24</option>
<option>25</option>
<option>26</option>
<option>27</option>
<option>28</option>
<option>29</option>
<option>30</option>
<option>31</option>
<option>32</option>
<option>33</option>
<option>34</option>
<option>35</option>
<option>36</option>
<option>37</option>
<option>38</option>
<option>39</option>
<option>40</option>
<option>41</option>
<option>42</option>
<option>43</option>
<option>44</option>
<option>45</option>
<option>46</option>
<option>47</option>
<option>48</option>
<option>49</option>
<option>50</option>
<option>51</option>
<option>52</option>
<option>53</option>
<option>54</option>
<option>60</option>
</select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Phone</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="to_phone" tabindex="64" onfocus="highlight(event);" value="" size="11"></font></td><td align="center" colspan="2" bgcolor="dddddd"><font face="verdana" size="2">Attention</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="to_attn" tabindex="65" onfocus="highlight(event);" value="" size="10"></font></td></tr>
<tr><td align="left" rowspan="2" bgcolor="dddddd"><font face="verdana" size="2">Deliver<br><input type="text" name="deliver_date" tabindex="66" onfocus="highlight(event);" value="2015-07-10" size="9" onchange="Javascript:updatedeliverday(document.statusfullform.deliver_date.value)"></font></td><td align="center" width="5%" bgcolor="eeeeee"><font face="verdana" size="2"><input type="radio" tabindex="67" name="deliver_by" onfocus="highlight(event);" value="1"></font></td><td align="left" width="12%" bgcolor="eeeeee"><font face="verdana" size="2">before</font></td><td align="center" width="5%" bgcolor="eeeeee"><font face="verdana" size="2"><input type="radio" tabindex="67" name="deliver_by" onfocus="highlight(event);" value="2"></font></td><td align="left" width="10%" bgcolor="eeeeee"><font face="verdana" size="2">after</font></td><td align="center" width="5%" bgcolor="eeeeee"><font face="verdana" size="2"><input type="radio" tabindex="67" name="deliver_by" onfocus="highlight(event);" value="3"></font></td><td align="left" width="10%" bgcolor="eeeeee"><font face="verdana" size="2">at</font></td></tr>
<tr><td align="left" colspan="2" bgcolor="ffffff"><font face="verdana" size="2"><select name="deliver_day" tabindex="68" onchange="Javascript:DeliverDay(this.value)"> <option selected="" value="0">Today</option><option value="1">Sat</option><option value="2">Sun</option><option value="3">Mon</option><option value="4">Tue</option><option value="5">Wed</option><option value="6">Thu</option><option value="7">Fri</option></select></font></td><td align="left" colspan="2" bgcolor="ffffff"><font face="verdana" size="2"><select name="deliver_time" tabindex="69"> <option selected="">     </option><option> 1:00</option><option> 1:15</option><option> 1:30</option><option> 1:45</option><option> 2:00</option><option> 2:15</option><option> 2:30</option><option> 2:45</option><option> 3:00</option><option> 3:15</option><option> 3:30</option><option> 3:45</option><option> 4:00</option><option> 4:15</option><option> 4:30</option><option> 4:45</option><option> 5:00</option><option> 5:15</option><option> 5:30</option><option> 5:45</option><option> 6:00</option><option> 6:15</option><option> 6:30</option><option> 6:45</option><option> 7:00</option><option> 7:15</option><option> 7:30</option><option> 7:45</option><option> 8:00</option><option> 8:15</option><option> 8:30</option><option> 8:45</option><option> 9:00</option><option> 9:15</option><option> 9:30</option><option> 9:45</option><option>10:00</option><option>10:15</option><option>10:30</option><option>10:45</option><option>11:00</option><option>11:15</option><option>11:30</option><option>11:45</option><option>12:00</option><option>12:15</option><option>12:30</option><option>12:45</option></select></font></td><td align="left" colspan="2" bgcolor="ffffff"><font face="verdana" size="2"><select name="deliver_ampm" tabindex="70"> <option></option><option selected="">AM</option><option>PM</option></select></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Description</font></td><td colspan="6" bgcolor="eeeeee"><font face="verdana" size="2"><textarea name="description" tabindex="71" onfocus="highlight(event);" rows="2" cols="30"></textarea></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Manual<br>waybill</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="manual_wb" tabindex="72" onfocus="highlight(event);" value="" size="11"></font></td><td align="center" colspan="2" bgcolor="dddddd"><font face="verdana" size="2">Reference</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="chargecode" tabindex="73" onfocus="highlight(event);" value="edi0682773" size="10"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Weight(Lb)</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="weight" tabindex="74" onfocus="highlight(event);" value="" size="6"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2"><select name="pieces_type" tabindex="75"><option selected="">Pieces</option>
<option>Boxes</option>
<option>Parcels</option>
<option>Cooler</option>
<option>Floral Spray</option>
<option>Skids</option>
<option>Bottles</option>
<option>Gift Basket</option>
<option>Glass</option>
<option>Painting</option>
<option>Auto Parts</option>
<option>Frames</option>
</select></font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="pieces" tabindex="75" onfocus="highlight(event);" value="" size="4"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Volume (Cu. Ft.)</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="volume" tabindex="76" onfocus="highlight(event);" value="" size="6"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">STAT 15 (Core Only!)</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="77" name="checkbox1" onfocus="highlight(event);"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Special Handling</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="81" name="checkbox2" onfocus="highlight(event);"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">Oversize / Fragile</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="82" name="checkbox3" onfocus="highlight(event);"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Return</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="83" name="return" onfocus="highlight(event);"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">No signature&nbsp;<br>Required </font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="84" name="nosig" onfocus="highlight(event);"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">No Signature Required</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="85" name="xtra1" onfocus="highlight(event);"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">After Hours Service</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="86" name="xtra2" onfocus="highlight(event);"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">COD</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="87" name="xtra3" onfocus="highlight(event);"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">BID-Tender-RFQ</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="88" name="xtra4" onfocus="highlight(event);"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Truck Call</font></td><td align="left" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="89" name="xtra5" onfocus="highlight(event);"></font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">COD</font></td><td align="center" bgcolor="eeeeee"><font face="verdana" size="2"><input type="checkbox" tabindex="90" name="codbox" onfocus="highlight(event);"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Requested<br>vehicle</font></td><td colspan="6" bgcolor="eeeeee"><font face="verdana" size="2"><select name="req_vehicle" tabindex="91"><option>Any</option><option>CAR</option>
<option>TRUCK</option>
<option>Bike</option>
</select></font></td></tr>
<tr><td bgcolor="dddddd" align="center" colspan="7"><font face="verdana" size="2">Prices calculated for delivery by CAR</font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Distance</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">not &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">(Miles)&nbsp;&nbsp;&nbsp;<input type="text" name="ovrd_distance" tabindex="95" onfocus="highlight(event);" value="" size="8"></font></td></tr>
<input type="hidden" name="calc_distance" value=""><tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2"><b>Prices</b></font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><b>Calculated</b></font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><b>Overrides</b></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Pickup(14)</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">0.00</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_price_pickup" tabindex="100" onfocus="highlight(event);" value="" size="8"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Deliver(22)</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">14.64</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_price_delivery" tabindex="101" onfocus="highlight(event);" value="" size="8"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Weight</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">0.00</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_price_weight" tabindex="102" onfocus="highlight(event);" value="" size="8"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Pieces</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">0.00</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_price_pieces" tabindex="103" onfocus="highlight(event);" value="" size="8"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Volume</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">0.00</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="ovrd_price_volume" tabindex="104" onfocus="highlight(event);" value="" size="8"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2"><center><b>Total *</b></center></font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2">14.64</font></td><td align="right" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="price" tabindex="116" onfocus="highlight(event);" value="" size="12"></font></td></tr>
<tr><td bgcolor="dddddd" align="center" colspan="7"><font face="verdana" size="2">Supplemental Charges</font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Wait</font></td><td align="left" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="wait_time" tabindex="120" onfocus="highlight(event);" value="" size="16"></font></td><td align="center" colspan="2" bgcolor="dddddd"><font face="verdana" size="2">Charges</font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="wait_charges" tabindex="121" onfocus="highlight(event);" value="0.00" size="4"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Additional</font></td><td align="left" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="additional_desc" tabindex="122" onfocus="highlight(event);" value="" size="16"></font></td><td align="center" colspan="2" bgcolor="dddddd"><font face="verdana" size="2">Charges</font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="additional" tabindex="123" onfocus="highlight(event);" value="0.00" size="4"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Additional</font></td><td align="left" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="additional2_desc" tabindex="124" onfocus="highlight(event);" value="" size="16"></font></td><td align="center" colspan="2" bgcolor="dddddd"><font face="verdana" size="2">Charges</font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="additional2" tabindex="125" onfocus="highlight(event);" value="0.00" size="4"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Additional</font></td><td align="left" colspan="3" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="additional3_desc" tabindex="126" onfocus="highlight(event);" value="" size="16"></font></td><td align="center" colspan="2" bgcolor="dddddd"><font face="verdana" size="2">Charges</font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="additional3" tabindex="127" onfocus="highlight(event);" value="0.00" size="4"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Auth\'d by</font></td><td colspan="6" bgcolor="eeeeee"><font face="verdana" size="2"><input type="text" name="wait_auth" tabindex="128" onfocus="highlight(event);" value="" size="40"></font></td></tr>
<tr><td bgcolor="dddddd" align="left"><font face="verdana" size="2">Fuel **<br>surcharge </font></td><td align="right" colspan="2" bgcolor="eeeeee"><font face="verdana" size="2"><div align="left">6.00%</div>0.88</font></td><td align="center" colspan="3" bgcolor="dddddd"><font face="verdana" size="2">Invoiced</font></td><td align="right" bgcolor="eeeeee"><font face="verdana" size="2">No&nbsp;&nbsp;&nbsp;</font></td></tr>

</tbody></table></td></tr></tbody></table>
<p align="center"><input type="submit" tabindex="170" name="reprice" value="Re-price the order" style="font-weight:bold;
                       font-size:14;
                       color:white;
                       font-family:Comic Sans Ms; background:#A0A0A0"></p> <br>* The price calculator will determine prices for the delivery and each
      additional chargeable service ordered. &nbsp;You may override any of these
      OR enter a single price override for the entire order.<br>
      * Note: wait time and additional charges are incurred <i>after</i> the order
      is placed and are in addition to the order price. <br>** Fuel surcharges are calculated and applied when invoices are prepared,
     <u>using current rates</u>. If the rates change, this charge will change.<br></td></tr>

</tbody></table>
		
		</form>
	';

}

?>