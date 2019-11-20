<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Filesystem\Filesystem;

class CreateVideoWithoutHTMLCommand extends Command{
    
    protected static $defaultName = 'app:create-html-without';
    
    private $urlExcel;

    protected function configure()
    {
	
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('');
        
        //Retirer cette adresse pour utiliser celle en paramètre
        $this->urlExcel = __DIR__."/../../files/KeyWords Party Porn.xlsx";
        
        //Création du lecteur de fichier excel
        $inputFileType = 'Xlsx';
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        //$spreadsheet = $reader->load($this->urlExcel);
        $spreadsheet = $reader->load($this->urlExcel);
        
        $max = $spreadsheet->getActiveSheet()->getHighestRow('A');
        
        $transitions = array(
            'and',
            'but',
            'so',
            'because',
            'as a result,',
            'for instance,',
            'therefore,',
            'in other words,',
            'However,',
            'For instance,',
            'Above all,',
            'In addition,',
            'After that,',
            'Similarly,',
            'In conclusion,'
        );
		
        $category = array(
            "amateur",
            "bdsm",
            "ebony",
            "college",
            "ebony",
            "french",
            "lesbian",
            "milf",
            "orgy",
            "outdoor",
            "party",
            "russian"
        );
        
        $html = "";
        
        $transitionsCounter = 1;
        
        //Boucle pour générer 3 paragraphes
        for($i = 0; $i <= 2; $i++){
            
 
			$rand = rand (2, $max);
			$titleWord = $spreadsheet->getActiveSheet()->getCell('A'.$rand)->getValue();
			$html .= "<h2>".$titleWord."</h2>";
            
            
            //Génération d'un paragraphe de 10 lignes avec environ 10 mots par lignes
            //Soit un paragraphe de 100 mots
            $html .= '<p>';
            for($w = 1; $w <= 30; $w++){
                $rand = rand (2, $max);
                $word = $spreadsheet->getActiveSheet()->getCell('A'.$rand)->getValue();
				
				if($transitionsCounter == 40){
					$html .= "<a href='https://10minutesparty.com/category/".$category[array_rand($category)]."/'>".$word."</a> ";
				}
				else{
					$html .= $word." ";
				}                
                
                //Ajout d'un retour à la ligne
                if($w % 3 == 0){
                    $html .= ".<br>";
                }
                
                //Ajout de mot de transition
                if($transitionsCounter % 10 == 0){
                    $html .= $transitions[array_rand($transitions)].' ';
                }
                
                $transitionsCounter++;
				
            }
            $html .= '</p>';
        }
        
        $output->writeln($html);
    }
}
