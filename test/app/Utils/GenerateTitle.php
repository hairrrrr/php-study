<?php 

namespace App\Utils;

use App\Models\Note;

class GenerateTitle 
{
    public function generateTitle($title)
    {
        // 将标题中的数字拆出来
        $numbers  = $this->getTitleNumber($title);
        $newTitle = $this->nextTitle($numbers);
        // 按照规律不断尝试，找到第一个数据库中不存在的数据
        while (Note::where('title', $newTitle)->exists()) {
            $newTitle = "{$title}($i)";
            $newTitle = nextTitle($numbers);
        }
        return $newTitle;
    }

    public function nextTitle($numbers): string 
    {
        // file.txt 第一次复制 
        if( count($numbers) == 1 )
            $lastNumber = 0;
        else 
            $lastNumber = array_pop($numbers);
        $title = $numbers[0];
        if ( $lastNumber == 99 ) 
        {
            array_push($numbers, 99);
            $lastNumber = 1;
        }
        else
            $lastNumber++;
        array_push($numbers, $lastNumber);
        
        for($i = 1; $i < count($numbers); $i++)
        {
            $title .= "({$numbers[$i]})";    
        }
        
        return $title;
    }

    public function getTitleNumber($title): array
    {
        $numbers = [];
        $i = strlen($title) - 1;
        $j = $i;
        for(; $i >= 0; $i--)
        {
            if( $title[$i] >= '0' && $title[$i] <= '9' )
                continue;
            else if($title[$i] == ')')
                $j = $i;
            else if($title[$i] == '(' && $j - $i > 1)
            {
                $num = substr($title, $i + 1, $j - $i - 1);            
                array_unshift($numbers, intval($num));
            }
            else 
                break;       
        }
        
        array_unshift($numbers, substr($title, 0, $i + 1));
        return $numbers;
    }
}