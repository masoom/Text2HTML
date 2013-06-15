

<?php
if($argc==3 and substr($argv[1],-4)=='.txt'and($argv[2]=='-html'or $argv[2]=='-txt'))
{
	//getting name of the file
	$fileName = substr(strrchr($argv[1], 92), 1 );
	//getting name of the file without extension
	$fileNameSansXtn = substr($fileName,0,strpos($fileName,'.'));
	//getting location of the file to save txt file or html file
	$fileLoc = substr($argv[1],0,strrpos($argv[1], 92));
	$domImpl = new DOMImplementation();
	//Root element is list
	$dom = $domImpl->createDocument(NULL, "list");
	$dom->encoding = "UTF-8";
	//open the text file
	$fp = fopen($argv[1], 'rt');
	if(!$fp)
	{
		echo 'Could not open input text file namefile';
		exit;
	}
	//number of names of persons in the text file
	$num = 1;
	while (($line = fgets($fp)) !== false) 
	{
		$name = trim($line);
		$loc = strpos($name, " ");
		$firstname = substr($name, 0, $loc);
		$lastname = substr($name, $loc+1 );     
		//create the person element
		$person = $dom->createElement("person");
		$person->setAttribute("id", $num);
		//appending person to the root element list
		$person_child = $dom->documentElement->appendChild($person);
		//creating personal_name element
		$personal_name = $dom->createElement('personal_name',$firstname);
		//creating family_name element
		$family_name = $dom->createElement('family_name',$lastname);
		//appending personal_name to person
		$person_child->appendChild($personal_name);
		//appending family_name to person
		$person_child->appendChild($family_name);     
		$num++;
	}
	if (!feof($fp)) 
	{
		echo "Error: unexpected fgets() fail\n";
	}
	fclose($fp);
	$dom->save($fileLoc."\\".$fileNameSansXtn.".xml");
	//to txt conversion
	if($argv[2]=='-txt')
	{
		//creating DOMDocument to load xml file
		$xml = new DOMDocument;
		//loading xml file
		$xml->load($fileLoc."\\".$fileNameSansXtn.".xml");
		//creating DOMDocument to load style sheet
		$xsl2TXT = new DOMDocument;
		//loading style sheet
		$xsl2TXT->load($fileLoc."\\"."sort2text.xsl");
		//Configure the transformer
		$proc = new XSLTProcessor;
		//attach the xsl rules
		$proc->importStyleSheet($xsl2TXT);
		if($xml_output = $proc->transformToXML($xml)) 
		{
			echo $xml_output;
			//writing to text file
			file_put_contents($fileLoc."\\".$fileNameSansXtn.".2.txt", $xml_output);
		} 
		else 
		{
			echo "error";
		}
	}
	//to html conversion
	else if($argv[2]=='-html')
	{
		//creating DOMDocument to load xml file
		$xml1 = new DOMDocument;
		//loading xml file
		$xml1->load($fileLoc."\\".$fileNameSansXtn.".xml");
		//creating DOMDocument to load style sheet
		$xsl2HTML = new DOMDocument;
		//loading style sheet
		$xsl2HTML->load($fileLoc."\\"."sort2html.xsl");
		//Configure the transformer
		$proc1 = new XSLTProcessor;
		//attach the xsl rules
		$proc1->importStyleSheet($xsl2HTML);// attach the xsl rules
		if($xml_output1 = $proc1->transformToXML($xml1)) 
		{
			echo $xml_output1;
			//writing to html file
			file_put_contents($fileLoc."\\".$fileNameSansXtn.".3.html", $xml_output1);
		} 
		else 
		{
			echo "error";
		}
	}
}
//if the are arguments are missing
else
{	
	if($argc==1)
		echo "input file and out file format arguments are missing";
	else if((strpos($argv[1],'.txt')==NULL))
		echo "wrong or missing input text file";
	else 
		echo "wrong or missing ouput file format";
}
?>	