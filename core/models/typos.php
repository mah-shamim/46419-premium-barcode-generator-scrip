<?php
/**
 * Typo: a Class for calculate domain name typos (bad typing errors)
 * @author Daniel Calvi (dacalvi at gmail)
 * @return array containing the list of typos
 * @version 1.0
 * @example $typos = new Typo("google")
 * 
*/
class typos {
	
	function get($dominio) {
		$dominios_mal_tipeados = array();
	    
		//Busqueda de caracteres repetidos que por error se tipean una sola vez
	    $arrayDominio = $this->str2array($dominio);
	    
	    $repeticion = false;
	    $dominio_repetido = array();
	    foreach($arrayDominio as $key=>$value){
	        if($key < strlen($dominio)){
	            if($value == $arrayDominio[$key+1]){
	                $repeticion = true;    
	            }else{
	                $dominio_repetido[] = $value;
	            }
	        }
	    }
	    
	    if($repeticion){
	        $dominios_mal_tipeados[] = join("", $dominio_repetido);
	    }
		
	    
	    //Regla de proximidad de teclas
	    $array_proximidades = array();
	    $array_proximidades['a'] = array('q', 'w', 'z', 'x');
	    $array_proximidades['b'] = array('v', 'f', 'g', 'h', 'n');
	    $array_proximidades['c'] = array('x', 's', 'd', 'f', 'v');
	    $array_proximidades['d'] = array('x', 's', 'w', 'e', 'r', 'f', 'v', 'c');
	    $array_proximidades['e'] = array('w', 's', 'd', 'f', 'r');
	    $array_proximidades['f'] = array('c', 'd', 'e', 'r', 't', 'g', 'b', 'v');
	    $array_proximidades['g'] = array('r', 'f', 'v', 't', 'b', 'y', 'h', 'n');
	    $array_proximidades['h'] = array('b', 'g', 't', 'y', 'u', 'j', 'm', 'n');
	    $array_proximidades['i'] = array('u', 'j', 'k', 'l', 'o');
	    $array_proximidades['j'] = array('n', 'h', 'y', 'u', 'i', 'k', 'm');
	    $array_proximidades['k'] = array('u', 'j', 'm', 'l', 'o');
	    $array_proximidades['l'] = array('p', 'o', 'i', 'k', 'm');
	    $array_proximidades['m'] = array('n', 'h', 'j', 'k', 'l');
	    $array_proximidades['n'] = array('b', 'g', 'h', 'j', 'm');
	    $array_proximidades['o'] = array('i', 'k', 'l', 'p');
	    $array_proximidades['p'] = array('o', 'l');
	    $array_proximidades['r'] = array('e', 'd', 'f', 'g', 't');
	    $array_proximidades['s'] = array('q', 'w', 'e', 'z', 'x', 'c');
	    $array_proximidades['t'] = array('r', 'f', 'g', 'h', 'y');
	    $array_proximidades['u'] = array('y', 'h', 'j', 'k', 'i');
	    $array_proximidades['v'] = array('', 'c', 'd', 'f', 'g', 'b');    
	    $array_proximidades['w'] = array('q', 'a', 's', 'd', 'e');
	    $array_proximidades['x'] = array('z', 'a', 's', 'd', 'c');
	    $array_proximidades['y'] = array('t', 'g', 'h', 'j', 'u');
	    $array_proximidades['z'] = array('x', 's', 'a');
	    $array_proximidades['1'] = array('q', 'w');
	    $array_proximidades['2'] = array('q', 'w', 'e');
	    $array_proximidades['3'] = array('w', 'e', 'r');
	    $array_proximidades['4'] = array('e', 'r', 't');
	    $array_proximidades['5'] = array('r', 't', 'y');
	    $array_proximidades['6'] = array('t', 'y', 'u');
	    $array_proximidades['7'] = array('y', 'u', 'i');
	    $array_proximidades['8'] = array('u', 'i', 'o');
	    $array_proximidades['9'] = array('i', 'o', 'p');
	    $array_proximidades['0'] = array('o', 'p');
	    
			                                         
	    foreach($arrayDominio as $key=>$value){
	        $temp_domain = $arrayDominio;
	        foreach ($array_proximidades[$value] as $tecla_proxima){
	            $temp_domain[$key] = $tecla_proxima;
	            $dominios_mal_tipeados[] = join("", $temp_domain);
	        }
	    }
	    return $dominios_mal_tipeados;
	}
		
	
	function str2array($str) {
		$ret = array();
		for ($i=0; $i<strlen($str); $i++) {
			$ret[] = substr($str, $i, 1);
		}
        return $ret;
	}
	
}