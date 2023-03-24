<?php
      //Check If Shipping Address Has Been Added Already
    $CheckAddress = "SELECT * FROM _users WHERE _email = '$_user_email_address'";
    $AddressAdded = $con->query($CheckAddress);

    if ($AddressAdded->num_rows > 0) {
        $row = $AddressAdded->fetch_assoc();
        $city = $row["_city"];

        //if ($state === ) {echo "selected";}
    }else{
        header("Location: 404");
    } 
?>
<option value="1329" <?php if ($city == "1329") {echo 'selected=""';}else{}?>>Abule Egba (Agbado Ijaye Road)</option>
									<option value="1811" <?php if ($city == "1811") {echo 'selected=""';}else{}?>>Abule Egba (Ajasa Command Rd)</option>
                                    <option value="1336" <?php if ($city == "1336") {echo 'selected=""';}else{}?>>Abule Egba (Ajegunle)</option>
                                    <option value="1324" <?php if ($city == "1324") {echo 'selected=""';}else{}?>>Abule Egba (Alagbado)</option>
                                    <option value="1325" <?php if ($city == "1325") {echo 'selected=""';}else{}?>>Abule Egba (Alakuko)</option>
                                    <option value="1322" <?php if ($city == "1322") {echo 'selected=""';}else{}?>>Abule Egba (Ekoro road)</option>
                                    <option value="1327" <?php if ($city == "1327") {echo 'selected=""';}else{}?>>Abule Egba (Meiran Road)</option>
                                    <option value="1326" <?php if ($city == "1326") {echo 'selected=""';}else{}?>>Abule Egba (New Oko Oba)</option>
                                    <option value="1323" <?php if ($city == "1323") {echo 'selected=""';}else{}?>>Abule Egba (Old Otta Road)</option>
                                    <option value="2818" <?php if ($city == "2818") {echo 'selected=""';}else{}?>>Agbara</option>
                                    <option value="1319" <?php if ($city == "1319") {echo 'selected=""';}else{}?>>Agege (Ajuwon Akute Road)</option>
                                    <option value="1320" <?php if ($city == "1320") {echo 'selected=""';}else{}?>>Agege (Dopemu)</option>
                                    <option value="1318" <?php if ($city == "1318") {echo 'selected=""';}else{}?>>Agege (Iju Road)</option>
                                    <option value="1316" <?php if ($city == "1316") {echo 'selected=""';}else{}?>>Agege (Old Abeokuta Road)</option>
                                    <option value="1315" <?php if ($city == "1315") {echo 'selected=""';}else{}?>>Agege (Old Otta Road)</option>
                                    <option value="1317" <?php if ($city == "1317") {echo 'selected=""';}else{}?>>Agege (Orile Agege)</option>
                                    <option value="1211" <?php if ($city == "1211") {echo 'selected=""';}else{}?>>AGILITI</option>
                                    <option value="22" <?php if ($city == "22") {echo 'selected=""';}else{}?>>AGUNGI (LEKKI)</option>
                                    <option value="26" <?php if ($city == "26") {echo 'selected=""';}else{}?>>AJAO ESTATE</option>
                                    <option value="990" <?php if ($city == "990") {echo 'selected=""';}else{}?>>ALFA BEACH</option>
                                    <option value="1635" <?php if ($city == "1635") {echo 'selected=""';}else{}?>>AMUWO</option>
                                    <option value="44" <?php if ($city == "44") {echo 'selected=""';}else{}?>>ANTHONY VILLAGE</option>
                                    <option value="1197" <?php if ($city == "1197") {echo 'selected=""';}else{}?>>Apapa (Ajegunle)</option>
                                    <option value="1200" <?php if ($city == "1200") {echo 'selected=""';}else{}?>>Apapa (Amukoko)</option>
                                    <option value="1202" <?php if ($city == "1202") {echo 'selected=""';}else{}?>>Apapa (GRA)</option>
                                    <option value="1199" <?php if ($city == "1199") {echo 'selected=""';}else{}?>>Apapa (Kiri kiri)</option>
                                    <option value="1201" <?php if ($city == "1201") {echo 'selected=""';}else{}?>>Apapa (Olodi)</option>
                                    <option value="1204" <?php if ($city == "1204") {echo 'selected=""';}else{}?>>Apapa (Suru Alaba)</option>
                                    <option value="1198" <?php if ($city == "1198") {echo 'selected=""';}else{}?>>Apapa (Tincan)</option>
                                    <option value="1203" <?php if ($city == "1203") {echo 'selected=""';}else{}?>>Apapa (Warf Rd)</option>
                                    <option value="997" <?php if ($city == "997") {echo 'selected=""';}else{}?>>AWOYAYA</option>
                                    <option value="2138" <?php if ($city == "2138") {echo 'selected=""';}else{}?>>Awoyaya-Container bustop</option>
                                    <option value="2134" <?php if ($city == "2134") {echo 'selected=""';}else{}?>>Awoyaya-Eko Akete Estate</option>
                                    <option value="2140" <?php if ($city == "2140") {echo 'selected=""';}else{}?>>Awoyaya-Eputu</option>
                                    <option value="2137" <?php if ($city == "2137") {echo 'selected=""';}else{}?>>Awoyaya-Gbetu Iwerekun Road</option>
                                    <option value="2136" <?php if ($city == "2136") {echo 'selected=""';}else{}?>>Awoyaya-Idowu Eletu</option>
                                    <option value="2139" <?php if ($city == "2139") {echo 'selected=""';}else{}?>>Awoyaya-Mayfair Gardens</option>
                                    <option value="2135" <?php if ($city == "2135") {echo 'selected=""';}else{}?>>Awoyaya-Ogunlana Busstop</option>
                                    <option value="2142" <?php if ($city == "2142") {echo 'selected=""';}else{}?>>Awoyaya-Ologunfe</option>
                                    <option value="2141" <?php if ($city == "2141") {echo 'selected=""';}else{}?>>Awoyaya-Oribanwa</option>
                                    <option value="2813" <?php if ($city == "2813") {echo 'selected=""';}else{}?>>Badagry</option>
                                    <option value="61" <?php if ($city == "61") {echo 'selected=""';}else{}?>>BERGER</option>
                                    <option value="2148" <?php if ($city == "2148") {echo 'selected=""';}else{}?>>Bogije</option>
                                    <option value="1550" <?php if ($city == "1550") {echo 'selected=""';}else{}?>>Coker</option>
                                    <option value="1552" <?php if ($city == "1552") {echo 'selected=""';}else{}?>>Doyin</option>
                                    <option value="2024" <?php if ($city == "2024") {echo 'selected=""';}else{}?>>Ejigbo-Ailegun Road</option>
                                    <option value="1999" <?php if ($city == "1999") {echo 'selected=""';}else{}?>>Ejigbo-Bucknor</option>
                                    <option value="1997" <?php if ($city == "1997") {echo 'selected=""';}else{}?>>Ejigbo-Ile Epo</option>
                                    <option value="1996" <?php if ($city == "1996") {echo 'selected=""';}else{}?>>Ejigbo-Isheri Osun</option>
                                    <option value="1993" <?php if ($city == "1993") {echo 'selected=""';}else{}?>>Ejigbo-Jakande Wood Market</option>
                                    <option value="1990" <?php if ($city == "1990") {echo 'selected=""';}else{}?>>Ejigbo-NNPC Road</option>
                                    <option value="1992" <?php if ($city == "1992") {echo 'selected=""';}else{}?>>Ejigbo-Oke-Afa</option>
                                    <option value="1998" <?php if ($city == "1998") {echo 'selected=""';}else{}?>>Ejigbo-Pipeline</option>
                                    <option value="1995" <?php if ($city == "1995") {echo 'selected=""';}else{}?>>Ejigbo-Powerline</option>
                                    <option value="2147" <?php if ($city == "2147") {echo 'selected=""';}else{}?>>Elemoro</option>
                                    <option value="86" <?php if ($city == "86") {echo 'selected=""';}else{}?>>EPE</option>
                                    <option value="3002" <?php if ($city == "3002") {echo 'selected=""';}else{}?>>Fagba (Iju Road)</option>
                                    <option value="1439" <?php if ($city == "1439") {echo 'selected=""';}else{}?>>FESTAC (1st Avenue)</option>
                                    <option value="1440" <?php if ($city == "1440") {echo 'selected=""';}else{}?>>FESTAC (2nd Avenue)</option>
                                    <option value="1441" <?php if ($city == "1441") {echo 'selected=""';}else{}?>>FESTAC (3rd Avenue)</option>
                                    <option value="1442" <?php if ($city == "1442") {echo 'selected=""';}else{}?>>FESTAC (4th Avenue)</option>
                                    <option value="1443" <?php if ($city == "1443") {echo 'selected=""';}else{}?>>FESTAC (5th Avenue)</option>
                                    <option value="1444" <?php if ($city == "1444") {echo 'selected=""';}else{}?>>FESTAC (6th Avenue)</option>
                                    <option value="1445" <?php if ($city == "1445") {echo 'selected=""';}else{}?>>FESTAC (7th Avenue)</option>
                                    <option value="1953" <?php if ($city == "1953") {echo 'selected=""';}else{}?>>Gbagada- Ifako</option>
                                    <option value="1960" <?php if ($city == "1960") {echo 'selected=""';}else{}?>>Gbagada-Abule Okuta</option>
                                    <option value="1959" <?php if ($city == "1959") {echo 'selected=""';}else{}?>>Gbagada-Araromi</option>
                                    <option value="1948" <?php if ($city == "1948") {echo 'selected=""';}else{}?>>Gbagada-Deeper Life</option>
                                    <option value="1951" <?php if ($city == "1951") {echo 'selected=""';}else{}?>>Gbagada-Diya</option>
                                    <option value="1957" <?php if ($city == "1957") {echo 'selected=""';}else{}?>>Gbagada-Expressway</option>
                                    <option value="1958" <?php if ($city == "1958") {echo 'selected=""';}else{}?>>Gbagada-Hospital</option>
                                    <option value="1950" <?php if ($city == "1950") {echo 'selected=""';}else{}?>>Gbagada-L&amp;K</option>
                                    <option value="1955" <?php if ($city == "1955") {echo 'selected=""';}else{}?>>Gbagada-New Garage</option>
                                    <option value="1949" <?php if ($city == "1949") {echo 'selected=""';}else{}?>>Gbagada-Olopomeji</option>
                                    <option value="1954" <?php if ($city == "1954") {echo 'selected=""';}else{}?>>Gbagada-Pedro</option>
                                    <option value="1956" <?php if ($city == "1956") {echo 'selected=""';}else{}?>>Gbagada-Sawmill</option>
                                    <option value="1952" <?php if ($city == "1952") {echo 'selected=""';}else{}?>>Gbagada-Sholuyi</option>
                                    <option value="3038" <?php if ($city == "3038") {echo 'selected=""';}else{}?>>Ibeju-Lekki Aiyeteju</option>
                                    <option value="3020" <?php if ($city == "3020") {echo 'selected=""';}else{}?>>Ibeju-Lekki Akodo</option>
                                    <option value="3042" <?php if ($city == "3042") {echo 'selected=""';}else{}?>>Ibeju-Lekki Amen Estate</option>
                                    <option value="3019" <?php if ($city == "3019") {echo 'selected=""';}else{}?>>Ibeju-Lekki Dangote fertilizer</option>
                                    <option value="3021" <?php if ($city == "3021") {echo 'selected=""';}else{}?>>Ibeju-Lekki Dangote Refinery</option>
                                    <option value="3022" <?php if ($city == "3022") {echo 'selected=""';}else{}?>>Ibeju-Lekki Dano Milk</option>
                                    <option value="3040" <?php if ($city == "3040") {echo 'selected=""';}else{}?>>Ibeju-Lekki Eleko Junction</option>
                                    <option value="3037" <?php if ($city == "3037") {echo 'selected=""';}else{}?>>Ibeju-Lekki Igando</option>
                                    <option value="3018" <?php if ($city == "3018") {echo 'selected=""';}else{}?>>Ibeju-Lekki Magbon</option>
                                    <option value="3039" <?php if ($city == "3039") {echo 'selected=""';}else{}?>>Ibeju-Lekki Onosa</option>
                                    <option value="3023" <?php if ($city == "3023") {echo 'selected=""';}else{}?>>Ibeju-Lekki Orimedu</option>
                                    <option value="3041" <?php if ($city == "3041") {echo 'selected=""';}else{}?>>Ibeju-Lekki Pan African University</option>
                                    <option value="3036" <?php if ($city == "3036") {echo 'selected=""';}else{}?>>Ibeju-Lekki Shapati</option>
                                    <option value="111" <?php if ($city == "111") {echo 'selected=""';}else{}?>>IDIMU</option>
                                    <option value="114" <?php if ($city == "114") {echo 'selected=""';}else{}?>>IGANDO</option>
                                    <option value="121" <?php if ($city == "121") {echo 'selected=""';}else{}?>>IJANIKIN</option>
                                    <option value="125" <?php if ($city == "125") {echo 'selected=""';}else{}?>>IJEGUN IKOTUN</option>
                                    <option value="2099" <?php if ($city == "2099") {echo 'selected=""';}else{}?>>Ijegun-Obadore Road</option>
                                    <option value="126" <?php if ($city == "126") {echo 'selected=""';}else{}?>>IJORA</option>
                                    <option value="1177" <?php if ($city == "1177") {echo 'selected=""';}else{}?>>Ikeja (ADENIYI JONES)</option>
                                    <option value="1176" <?php if ($city == "1176") {echo 'selected=""';}else{}?>>Ikeja (ALAUSA)</option>
                                    <option value="1175" <?php if ($city == "1175") {echo 'selected=""';}else{}?>>Ikeja (ALLEN AVENUE)</option>
                                    <option value="1205" <?php if ($city == "1205") {echo 'selected=""';}else{}?>>Ikeja (computer village)</option>
                                    <option value="1178" <?php if ($city == "1178") {echo 'selected=""';}else{}?>>Ikeja (GRA)</option>
                                    <option value="1822" <?php if ($city == "1822") {echo 'selected=""';}else{}?>>IKEJA (M M Airport)</option>
                                    <option value="1184" <?php if ($city == "1184") {echo 'selected=""';}else{}?>>Ikeja (MANGORO)</option>
                                    <option value="1182" <?php if ($city == "1182") {echo 'selected=""';}else{}?>>Ikeja (OBA-AKRAN)</option>
                                    <option value="1181" <?php if ($city == "1181") {echo 'selected=""';}else{}?>>Ikeja (OPEBI)</option>
                                    <option value="1351" <?php if ($city == "1351") {echo 'selected=""';}else{}?>>IKORODU (Adamo)</option>
                                    <option value="1343" <?php if ($city == "1343") {echo 'selected=""';}else{}?>>IKORODU (Agbede)</option>
                                    <option value="1544" <?php if ($city == "1544") {echo 'selected=""';}else{}?>>Ikorodu (Agbowa)</option>
                                    <option value="2404" <?php if ($city == "2404") {echo 'selected=""';}else{}?>>IKORODU (Agric)</option>
                                    <option value="1340" <?php if ($city == "1340") {echo 'selected=""';}else{}?>>IKORODU (Bayeku)</option>
                                    <option value="1342" <?php if ($city == "1342") {echo 'selected=""';}else{}?>>IKORODU (Eyita)</option>
                                    <option value="1345" <?php if ($city == "1345") {echo 'selected=""';}else{}?>>IKORODU (Gberigbe)</option>
                                    <option value="2405" <?php if ($city == "2405") {echo 'selected=""';}else{}?>>IKORODU (Ijede)</option>
                                    <option value="1350" <?php if ($city == "1350") {echo 'selected=""';}else{}?>>IKORODU (Imota)</option>
                                    <option value="1344" <?php if ($city == "1344") {echo 'selected=""';}else{}?>>IKORODU (Ita oluwo)</option>
                                    <option value="1347" <?php if ($city == "1347") {echo 'selected=""';}else{}?>>IKORODU (Itamaga)</option>
                                    <option value="1341" <?php if ($city == "1341") {echo 'selected=""';}else{}?>>IKORODU (Offin)</option>
                                    <option value="1339" <?php if ($city == "1339") {echo 'selected=""';}else{}?>>IKORODU (Owode-Ibese)</option>
                                    <option value="2110" <?php if ($city == "2110") {echo 'selected=""';}else{}?>>Ikorodu Road-Ajegunle</option>
                                    <option value="2112" <?php if ($city == "2112") {echo 'selected=""';}else{}?>>Ikorodu Road-Irawo</option>
                                    <option value="2111" <?php if ($city == "2111") {echo 'selected=""';}else{}?>>Ikorodu Road-Owode Onirin</option>
                                    <option value="1346" <?php if ($city == "1346") {echo 'selected=""';}else{}?>>IKORODU(Elepe)</option>
                                    <option value="1349" <?php if ($city == "1349") {echo 'selected=""';}else{}?>>IKORODU(Laspotech)</option>
                                    <option value="1352" <?php if ($city == "1352") {echo 'selected=""';}else{}?>>Ikorodu(Ogolonto)</option>
                                    <option value="1348" <?php if ($city == "1348") {echo 'selected=""';}else{}?>>IKORODU(Sabo)</option>
                                    <option value="2118" <?php if ($city == "2118") {echo 'selected=""';}else{}?>>Ikorodu- Imota Caleb University</option>
                                    <option value="2117" <?php if ($city == "2117") {echo 'selected=""';}else{}?>>Ikorodu-Agufoye</option>
                                    <option value="2109" <?php if ($city == "2109") {echo 'selected=""';}else{}?>>Ikorodu-Benson</option>
                                    <option value="2122" <?php if ($city == "2122") {echo 'selected=""';}else{}?>>Ikorodu-Garage</option>
                                    <option value="2121" <?php if ($city == "2121") {echo 'selected=""';}else{}?>>Ikorodu-Odokekere</option>
                                    <option value="2120" <?php if ($city == "2120") {echo 'selected=""';}else{}?>>Ikorodu-Odonla</option>
                                    <option value="2119" <?php if ($city == "2119") {echo 'selected=""';}else{}?>>Ikorodu-Ogijo</option>
                                    <option value="993" <?php if ($city == "993") {echo 'selected=""';}else{}?>>IKOTA</option>
                                    <option value="137" <?php if ($city == "137") {echo 'selected=""';}else{}?>>IKOTUN</option>
                                    <option value="1225" <?php if ($city == "1225") {echo 'selected=""';}else{}?>>Ikoyi (Awolowo Road)</option>
                                    <option value="1228" <?php if ($city == "1228") {echo 'selected=""';}else{}?>>Ikoyi (Bourdillon)</option>
                                    <option value="1243" <?php if ($city == "1243") {echo 'selected=""';}else{}?>>Ikoyi (Dolphin)</option>
                                    <option value="1230" <?php if ($city == "1230") {echo 'selected=""';}else{}?>>Ikoyi (Glover road)</option>
                                    <option value="1227" <?php if ($city == "1227") {echo 'selected=""';}else{}?>>Ikoyi (Keffi)</option>
                                    <option value="1226" <?php if ($city == "1226") {echo 'selected=""';}else{}?>>Ikoyi (Kings way road)</option>
                                    <option value="1241" <?php if ($city == "1241") {echo 'selected=""';}else{}?>>Ikoyi (Obalende)</option>
                                    <option value="1229" <?php if ($city == "1229") {echo 'selected=""';}else{}?>>Ikoyi (Queens Drive)</option>
                                    <option value="1823" <?php if ($city == "1823") {echo 'selected=""';}else{}?>>IKOYI MTN ( PICKUP STATION)</option>
                                    <option value="3017" <?php if ($city == "3017") {echo 'selected=""';}else{}?>>Ikoyi-Banana Island</option>
                                    <option value="1586" <?php if ($city == "1586") {echo 'selected=""';}else{}?>>ILAJE (BARIGA)</option>
                                    <option value="147" <?php if ($city == "147") {echo 'selected=""';}else{}?>>ILUPEJU (Lagos)</option>
                                    <option value="941" <?php if ($city == "941") {echo 'selected=""';}else{}?>>ISHERI IKOTUN</option>
                                    <option value="153" <?php if ($city == "153") {echo 'selected=""';}else{}?>>ISHERI MAGODO</option>
                                    <option value="155" <?php if ($city == "155") {echo 'selected=""';}else{}?>>ISOLO</option>
                                    <option value="2000" <?php if ($city == "2000") {echo 'selected=""';}else{}?>>Iyana Ejigbo</option>
                                    <option value="162" <?php if ($city == "162") {echo 'selected=""';}else{}?>>IYANA IBA</option>
                                    <option value="1334" <?php if ($city == "1334") {echo 'selected=""';}else{}?>>Iyana Ipaja (Abesan)</option>
                                    <option value="2993" <?php if ($city == "2993") {echo 'selected=""';}else{}?>>Iyana Ipaja (Aboru)</option>
                                    <option value="1593" <?php if ($city == "1593") {echo 'selected=""';}else{}?>>Iyana Ipaja (Ayobo Road)</option>
                                    <option value="1330" <?php if ($city == "1330") {echo 'selected=""';}else{}?>>Iyana Ipaja (Command Road)</option>
                                    <option value="1332" <?php if ($city == "1332") {echo 'selected=""';}else{}?>>Iyana Ipaja (Egbeda)</option>
                                    <option value="1331" <?php if ($city == "1331") {echo 'selected=""';}else{}?>>Iyana Ipaja (Ikola Road)</option>
                                    <option value="1333" <?php if ($city == "1333") {echo 'selected=""';}else{}?>>Iyana Ipaja (Iyana Ipaja Road)</option>
                                    <option value="1335" <?php if ($city == "1335") {echo 'selected=""';}else{}?>>Iyana Ipaja (Shasha)</option>
                                    <option value="1627" <?php if ($city == "1627") {echo 'selected=""';}else{}?>>JAKANDE (LEKKI)</option>
                                    <option value="1589" <?php if ($city == "1589") {echo 'selected=""';}else{}?>>JANKANDE (ISOLO)</option>
                                    <option value="1626" <?php if ($city == "1626") {echo 'selected=""';}else{}?>>Jumia-Experience-Center</option>
                                    <option value="2233" <?php if ($city == "2233") {echo 'selected=""';}else{}?>>Ketu- Agboyi</option>
                                    <option value="2231" <?php if ($city == "2231") {echo 'selected=""';}else{}?>>Ketu-Alapere</option>
                                    <option value="2230" <?php if ($city == "2230") {echo 'selected=""';}else{}?>>Ketu-CMD road</option>
                                    <option value="2235" <?php if ($city == "2235") {echo 'selected=""';}else{}?>>Ketu-Demurin</option>
                                    <option value="2228" <?php if ($city == "2228") {echo 'selected=""';}else{}?>>Ketu-Ikosi Road</option>
                                    <option value="2232" <?php if ($city == "2232") {echo 'selected=""';}else{}?>>Ketu-Ile Ile</option>
                                    <option value="2229" <?php if ($city == "2229") {echo 'selected=""';}else{}?>>Ketu-Iyana School</option>
                                    <option value="2234" <?php if ($city == "2234") {echo 'selected=""';}else{}?>>Ketu-Tipper Garage</option>
                                    <option value="1238" <?php if ($city == "1238") {echo 'selected=""';}else{}?>>Lagos Island (Adeniji)</option>
                                    <option value="1237" <?php if ($city == "1237") {echo 'selected=""';}else{}?>>Lagos Island (Marina)</option>
                                    <option value="1239" <?php if ($city == "1239") {echo 'selected=""';}else{}?>>Lagos Island (Onikan)</option>
                                    <option value="1240" <?php if ($city == "1240") {echo 'selected=""';}else{}?>>Lagos Island (Sura)</option>
                                    <option value="1242" <?php if ($city == "1242") {echo 'selected=""';}else{}?>>Lagos Island (TBS)</option>
                                    <option value="996" <?php if ($city == "996") {echo 'selected=""';}else{}?>>LAKOWE</option>
                                    <option value="2145" <?php if ($city == "2145") {echo 'selected=""';}else{}?>>Lakowe-Adeba Road</option>
                                    <option value="2144" <?php if ($city == "2144") {echo 'selected=""';}else{}?>>Lakowe-Golf</option>
                                    <option value="2146" <?php if ($city == "2146") {echo 'selected=""';}else{}?>>Lakowe-Kajola</option>
                                    <option value="2143" <?php if ($city == "2143") {echo 'selected=""';}else{}?>>Lakowe-School Gate</option>
                                    <option value="1655" <?php if ($city == "1655") {echo 'selected=""';}else{}?>>LEKKI -VGC</option>
                                    <option value="1824" <?php if ($city == "1824") {echo 'selected=""';}else{}?>>Lekki 1 (Bishop Durosimi)</option>
                                    <option value="1825" <?php if ($city == "1825") {echo 'selected=""';}else{}?>>Lekki 1 (F.T Kuboye street)</option>
                                    <option value="1826" <?php if ($city == "1826") {echo 'selected=""';}else{}?>>Lekki 1 (Omorinre Johnson)</option>
                                    <option value="1234" <?php if ($city == "1234") {echo 'selected=""';}else{}?>>Lekki Phase 1 (Admiralty Road)</option>
                                    <option value="1231" <?php if ($city == "1231") {echo 'selected=""';}else{}?>>Lekki Phase 1 (Admiralty way)</option>
                                    <option value="1232" <?php if ($city == "1232") {echo 'selected=""';}else{}?>>Lekki Phase 1 (Fola Osibo)</option>
                                    <option value="1638" <?php if ($city == "1638") {echo 'selected=""';}else{}?>>LEKKI-AGUNGI</option>
                                    <option value="1658" <?php if ($city == "1658") {echo 'selected=""';}else{}?>>LEKKI-AJAH (ABIJO)</option>
                                    <option value="1647" <?php if ($city == "1647") {echo 'selected=""';}else{}?>>LEKKI-AJAH (ADDO ROAD)</option>
                                    <option value="1649" <?php if ($city == "1649") {echo 'selected=""';}else{}?>>LEKKI-AJAH (BADORE)</option>
                                    <option value="1650" <?php if ($city == "1650") {echo 'selected=""';}else{}?>>LEKKI-AJAH (ILAJE)</option>
                                    <option value="1651" <?php if ($city == "1651") {echo 'selected=""';}else{}?>>LEKKI-AJAH (ILASAN)</option>
                                    <option value="1652" <?php if ($city == "1652") {echo 'selected=""';}else{}?>>LEKKI-AJAH (JAKANDE)</option>
                                    <option value="1656" <?php if ($city == "1656") {echo 'selected=""';}else{}?>>LEKKI-AJAH (SANGOTEDO)</option>
                                    <option value="2871" <?php if ($city == "2871") {echo 'selected=""';}else{}?>>Lekki-Awoyaya</option>
                                    <option value="1961" <?php if ($city == "1961") {echo 'selected=""';}else{}?>>Lekki-Chisco</option>
                                    <option value="1639" <?php if ($city == "1639") {echo 'selected=""';}else{}?>>LEKKI-ELF</option>
                                    <option value="1640" <?php if ($city == "1640") {echo 'selected=""';}else{}?>>LEKKI-IGBOEFON</option>
                                    <option value="1641" <?php if ($city == "1641") {echo 'selected=""';}else{}?>>LEKKI-IKATE ELEGUSHI</option>
                                    <option value="1657" <?php if ($city == "1657") {echo 'selected=""';}else{}?>>LEKKI-JAKANDE (KAZEEM ELETU)</option>
                                    <option value="1642" <?php if ($city == "1642") {echo 'selected=""';}else{}?>>LEKKI-MARUWA</option>
                                    <option value="1643" <?php if ($city == "1643") {echo 'selected=""';}else{}?>>LEKKI-ONIRU ESTATE</option>
                                    <option value="1644" <?php if ($city == "1644") {echo 'selected=""';}else{}?>>LEKKI-OSAPA LONDON</option>
                                    <option value="2994" <?php if ($city == "2994") {echo 'selected=""';}else{}?>>Magboro</option>
                                    <option value="200" <?php if ($city == "200") {echo 'selected=""';}else{}?>>MAGODO</option>
                                    <option value="1592" <?php if ($city == "1592") {echo 'selected=""';}else{}?>>MARYLAND (MENDE)</option>
                                    <option value="1591" <?php if ($city == "1591") {echo 'selected=""';}else{}?>>MARYLAND (ONIGBONGBO)</option>
                                    <option value="209" <?php if ($city == "209") {echo 'selected=""';}else{}?>>MEBANMU</option>
                                    <option value="210" <?php if ($city == "210") {echo 'selected=""';}else{}?>>MILE 12</option>
                                    <option value="2113" <?php if ($city == "2113") {echo 'selected=""';}else{}?>>Mile 12 -Ajelogo</option>
                                    <option value="2116" <?php if ($city == "2116") {echo 'selected=""';}else{}?>>Mile 12-Agboyi Ketu</option>
                                    <option value="2114" <?php if ($city == "2114") {echo 'selected=""';}else{}?>>Mile 12-Doyin Omololu</option>
                                    <option value="2115" <?php if ($city == "2115") {echo 'selected=""';}else{}?>>Mile 12-Orishigun</option>
                                    <option value="211" <?php if ($city == "211") {echo 'selected=""';}else{}?>>MILE 2</option>
                                    <option value="2041" <?php if ($city == "2041") {echo 'selected=""';}else{}?>>Mushin -Palm Avenue</option>
                                    <option value="2038" <?php if ($city == "2038") {echo 'selected=""';}else{}?>>Mushin-Agege Motor Road</option>
                                    <option value="2033" <?php if ($city == "2033") {echo 'selected=""';}else{}?>>Mushin-Daleko Market</option>
                                    <option value="2043" <?php if ($city == "2043") {echo 'selected=""';}else{}?>>Mushin-Fatai Atere</option>
                                    <option value="2035" <?php if ($city == "2035") {echo 'selected=""';}else{}?>>Mushin-Idi Oro</option>
                                    <option value="2039" <?php if ($city == "2039") {echo 'selected=""';}else{}?>>Mushin-Idi-Araba</option>
                                    <option value="2040" <?php if ($city == "2040") {echo 'selected=""';}else{}?>>Mushin-Ilasamaja Road</option>
                                    <option value="2037" <?php if ($city == "2037") {echo 'selected=""';}else{}?>>Mushin-Isolo Road</option>
                                    <option value="2034" <?php if ($city == "2034") {echo 'selected=""';}else{}?>>Mushin-Ladipo Road</option>
                                    <option value="2032" <?php if ($city == "2032") {echo 'selected=""';}else{}?>>Mushin-Mushin Market</option>
                                    <option value="2036" <?php if ($city == "2036") {echo 'selected=""';}else{}?>>Mushin-Olateju</option>
                                    <option value="2042" <?php if ($city == "2042") {echo 'selected=""';}else{}?>>Mushin-Papa Ajao</option>
                                    <option value="1214" <?php if ($city == "1214") {echo 'selected=""';}else{}?>>Odongunyan</option>
                                    <option value="1877" <?php if ($city == "1877") {echo 'selected=""';}else{}?>>Ogba- Akilo Road</option>
                                    <option value="1876" <?php if ($city == "1876") {echo 'selected=""';}else{}?>>Ogba- College Road</option>
                                    <option value="1878" <?php if ($city == "1878") {echo 'selected=""';}else{}?>>Ogba- Lateef Jakande Road</option>
                                    <option value="1873" <?php if ($city == "1873") {echo 'selected=""';}else{}?>>Ogba-Acme Road</option>
                                    <option value="1868" <?php if ($city == "1868") {echo 'selected=""';}else{}?>>Ogba-Aguda</option>
                                    <option value="1804" <?php if ($city == "1804") {echo 'selected=""';}else{}?>>Ogba-County</option>
                                    <option value="1871" <?php if ($city == "1871") {echo 'selected=""';}else{}?>>Ogba-Ifako-Idiagbon</option>
                                    <option value="1870" <?php if ($city == "1870") {echo 'selected=""';}else{}?>>Ogba-Ifako-Orimolade</option>
                                    <option value="1867" <?php if ($city == "1867") {echo 'selected=""';}else{}?>>Ogba-Isheri Road</option>
                                    <option value="1874" <?php if ($city == "1874") {echo 'selected=""';}else{}?>>Ogba-Obawole</option>
                                    <option value="1879" <?php if ($city == "1879") {echo 'selected=""';}else{}?>>Ogba-Ojodu</option>
                                    <option value="1872" <?php if ($city == "1872") {echo 'selected=""';}else{}?>>Ogba-Oke Ira</option>
                                    <option value="1875" <?php if ($city == "1875") {echo 'selected=""';}else{}?>>Ogba-Oke Ira 2nd Juction</option>
                                    <option value="2443" <?php if ($city == "2443") {echo 'selected=""';}else{}?>>OGBA-Surulere Ind Rd</option>
                                    <option value="1869" <?php if ($city == "1869") {echo 'selected=""';}else{}?>>Ogba-Wemco Road</option>
                                    <option value="237" <?php if ($city == "237") {echo 'selected=""';}else{}?>>OGUDU</option>
                                    <option value="238" <?php if ($city == "238") {echo 'selected=""';}else{}?>>OJO</option>
                                    <option value="2805" <?php if ($city == "2805") {echo 'selected=""';}else{}?>>Ojo Shibiri</option>
                                    <option value="2326" <?php if ($city == "2326") {echo 'selected=""';}else{}?>>Ojo-Abule Oshun</option>
                                    <option value="2340" <?php if ($city == "2340") {echo 'selected=""';}else{}?>>Ojo-Adaloko</option>
                                    <option value="2330" <?php if ($city == "2330") {echo 'selected=""';}else{}?>>Ojo-Agric</option>
                                    <option value="2775" <?php if ($city == "2775") {echo 'selected=""';}else{}?>>Ojo-Ajangbadi</option>
                                    <option value="2318" <?php if ($city == "2318") {echo 'selected=""';}else{}?>>Ojo-Alaba International</option>
                                    <option value="2319" <?php if ($city == "2319") {echo 'selected=""';}else{}?>>Ojo-Alaba Rago</option>
                                    <option value="2320" <?php if ($city == "2320") {echo 'selected=""';}else{}?>>Ojo-Alaba Suru</option>
                                    <option value="2332" <?php if ($city == "2332") {echo 'selected=""';}else{}?>>Ojo-Alakija</option>
                                    <option value="2323" <?php if ($city == "2323") {echo 'selected=""';}else{}?>>Ojo-Cassidy</option>
                                    <option value="2327" <?php if ($city == "2327") {echo 'selected=""';}else{}?>>Ojo-Ijegun</option>
                                    <option value="2339" <?php if ($city == "2339") {echo 'selected=""';}else{}?>>Ojo-Ilogbo</option>
                                    <option value="2324" <?php if ($city == "2324") {echo 'selected=""';}else{}?>>Ojo-Ojo Barracks</option>
                                    <option value="2335" <?php if ($city == "2335") {echo 'selected=""';}else{}?>>Ojo-Okokomaiko</option>
                                    <option value="2333" <?php if ($city == "2333") {echo 'selected=""';}else{}?>>Ojo-Old Ojo road</option>
                                    <option value="2328" <?php if ($city == "2328") {echo 'selected=""';}else{}?>>Ojo-Onireke</option>
                                    <option value="2322" <?php if ($city == "2322") {echo 'selected=""';}else{}?>>Ojo-PPL</option>
                                    <option value="2341" <?php if ($city == "2341") {echo 'selected=""';}else{}?>>Ojo-Shibiri</option>
                                    <option value="2331" <?php if ($city == "2331") {echo 'selected=""';}else{}?>>Ojo-Tedi Town</option>
                                    <option value="2325" <?php if ($city == "2325") {echo 'selected=""';}else{}?>>Ojo-Trade Fair</option>
                                    <option value="2329" <?php if ($city == "2329") {echo 'selected=""';}else{}?>>Ojo-Volks</option>
                                    <option value="242" <?php if ($city == "242") {echo 'selected=""';}else{}?>>OJODU</option>
                                    <option value="243" <?php if ($city == "243") {echo 'selected=""';}else{}?>>OJOKORO</option>
                                    <option value="244" <?php if ($city == "244") {echo 'selected=""';}else{}?>>OJOTA</option>
                                    <option value="248" <?php if ($city == "248") {echo 'selected=""';}else{}?>>OKOKOMAIKO</option>
                                    <option value="249" <?php if ($city == "249") {echo 'selected=""';}else{}?>>OKOTA</option>
                                    <option value="1185" <?php if ($city == "1185") {echo 'selected=""';}else{}?>>Omole Phase 1</option>
                                    <option value="1186" <?php if ($city == "1186") {echo 'selected=""';}else{}?>>Omole Phase 2</option>
                                    <option value="259" <?php if ($city == "259") {echo 'selected=""';}else{}?>>OREGUN</option>
                                    <option value="1546" <?php if ($city == "1546") {echo 'selected=""';}else{}?>>Oreyo- Igbe</option>
                                    <option value="260" <?php if ($city == "260") {echo 'selected=""';}else{}?>>ORILE</option>
                                    <option value="264" <?php if ($city == "264") {echo 'selected=""';}else{}?>>OSAPA (LEKKI)</option>
                                    <option value="1570" <?php if ($city == "1570") {echo 'selected=""';}else{}?>>OSHODI-BOLADE</option>
                                    <option value="1561" <?php if ($city == "1561") {echo 'selected=""';}else{}?>>OSHODI-ISOLO</option>
                                    <option value="265" <?php if ($city == "265") {echo 'selected=""';}else{}?>>OSHODI-MAFOLUKU</option>
                                    <option value="1559" <?php if ($city == "1559") {echo 'selected=""';}else{}?>>OSHODI-ORILE</option>
                                    <option value="1560" <?php if ($city == "1560") {echo 'selected=""';}else{}?>>OSHODI-SHOGUNLE</option>
                                    <option value="2997" <?php if ($city == "2997") {echo 'selected=""';}else{}?>>Palmgrove-Onipanu</option>
                                    <option value="1548" <?php if ($city == "1548") {echo 'selected=""';}else{}?>>Sari-Iganmu</option>
                                    <option value="2439" <?php if ($city == "2439") {echo 'selected=""';}else{}?>>Satelite-Town</option>
                                    <option value="293" <?php if ($city == "293") {echo 'selected=""';}else{}?>>SOMOLU</option>
                                    <option value="1207" <?php if ($city == "1207") {echo 'selected=""';}else{}?>>Surulere (Adeniran Ogunsanya)</option>
                                    <option value="1187" <?php if ($city == "1187") {echo 'selected=""';}else{}?>>Surulere (Aguda)</option>
                                    <option value="1194" <?php if ($city == "1194") {echo 'selected=""';}else{}?>>Surulere (Bode Thomas)</option>
                                    <option value="1206" <?php if ($city == "1206") {echo 'selected=""';}else{}?>>Surulere (Fatia Shitta)</option>
                                    <option value="1196" <?php if ($city == "1196") {echo 'selected=""';}else{}?>>Surulere (Idi Araba)</option>
                                    <option value="1193" <?php if ($city == "1193") {echo 'selected=""';}else{}?>>Surulere (Ijesha)</option>
                                    <option value="1195" <?php if ($city == "1195") {echo 'selected=""';}else{}?>>Surulere (Iponri)</option>
                                    <option value="1191" <?php if ($city == "1191") {echo 'selected=""';}else{}?>>Surulere (Itire)</option>
                                    <option value="1190" <?php if ($city == "1190") {echo 'selected=""';}else{}?>>Surulere (Lawanson)</option>
                                    <option value="1188" <?php if ($city == "1188") {echo 'selected=""';}else{}?>>Surulere (Masha)</option>
                                    <option value="1192" <?php if ($city == "1192") {echo 'selected=""';}else{}?>>Surulere (Ogunlana drive)</option>
                                    <option value="1189" <?php if ($city == "1189") {echo 'selected=""';}else{}?>>Surulere (Ojuelegba)</option>
                                    <option value="1831" <?php if ($city == "1831") {echo 'selected=""';}else{}?>>VI (Adetokunbo Ademola)</option>
                                    <option value="1832" <?php if ($city == "1832") {echo 'selected=""';}else{}?>>VI (Ahmed Bello way)</option>
                                    <option value="1962" <?php if ($city == "1962") {echo 'selected=""';}else{}?>>VI (Bishop Aboyade Cole)</option>
                                    <option value="1833" <?php if ($city == "1833") {echo 'selected=""';}else{}?>>VI(Ajose Adeogun)</option>
                                    <option value="1834" <?php if ($city == "1834") {echo 'selected=""';}else{}?>>VI(Akin Adeshola)</option>
                                    <option value="1835" <?php if ($city == "1835") {echo 'selected=""';}else{}?>>VI(Bishop Oluwale)</option>
                                    <option value="1836" <?php if ($city == "1836") {echo 'selected=""';}else{}?>>VI(Yusuf Abiodun)</option>
                                    <option value="1220" <?php if ($city == "1220") {echo 'selected=""';}else{}?>>Victoria Island (Adeola Odeku)</option>
                                    <option value="1223" <?php if ($city == "1223") {echo 'selected=""';}else{}?>>Victoria Island (Kofo Abayomi)</option>
                                    <option value="1892" <?php if ($city == "1892") {echo 'selected=""';}else{}?>>Yaba- Abule Ijesha</option>
                                    <option value="1891" <?php if ($city == "1891") {echo 'selected=""';}else{}?>>Yaba- Fadeyi</option>
                                    <option value="1899" <?php if ($city == "1899") {echo 'selected=""';}else{}?>>Yaba-(Sabo)</option>
                                    <option value="1898" <?php if ($city == "1898") {echo 'selected=""';}else{}?>>Yaba-(Unilag)</option>
                                    <option value="1882" <?php if ($city == "1882") {echo 'selected=""';}else{}?>>Yaba-Abule Oja</option>
                                    <option value="1888" <?php if ($city == "1888") {echo 'selected=""';}else{}?>>Yaba-Adekunle</option>
                                    <option value="1895" <?php if ($city == "1895") {echo 'selected=""';}else{}?>>Yaba-Akoka</option>
                                    <option value="1887" <?php if ($city == "1887") {echo 'selected=""';}else{}?>>Yaba-Alagomeju</option>
                                    <option value="1883" <?php if ($city == "1883") {echo 'selected=""';}else{}?>>Yaba-College of Education</option>
                                    <option value="1886" <?php if ($city == "1886") {echo 'selected=""';}else{}?>>Yaba-Commercial Avenue</option>
                                    <option value="1881" <?php if ($city == "1881") {echo 'selected=""';}else{}?>>Yaba-Folagoro</option>
                                    <option value="1893" <?php if ($city == "1893") {echo 'selected=""';}else{}?>>Yaba-Herbert Macaulay Way</option>
                                    <option value="1894" <?php if ($city == "1894") {echo 'selected=""';}else{}?>>Yaba-Jibowu</option>
                                    <option value="1897" <?php if ($city == "1897") {echo 'selected=""';}else{}?>>Yaba-Makoko</option>
                                    <option value="1896" <?php if ($city == "1896") {echo 'selected=""';}else{}?>>Yaba-Murtala Muhammed Way</option>
                                    <option value="1880" <?php if ($city == "1880") {echo 'selected=""';}else{}?>>Yaba-Onike Iwaya</option>
                                    <option value="1890" <?php if ($city == "1890") {echo 'selected=""';}else{}?>>Yaba-Oyingbo</option>
                                    <option value="1889" <?php if ($city == "1889") {echo 'selected=""';}else{}?>>Yaba-Tejuosho</option>
                                    <option value="1885" <?php if ($city == "1885") {echo 'selected=""';}else{}?>>Yaba-University Road</option>
                                    <option value="1884" <?php if ($city == "1884") {echo 'selected=""';}else{}?>>Yaba-Yabatech</option>