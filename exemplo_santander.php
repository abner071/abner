function createEntry($key, $value)
{
    $toReturn = array('key'   => $key,
                      'value' => $value);
    return $toReturn;
}

function getTicketXml()
{
    $dados = array(createEntry('CONVENIO.COD-BANCO', '0033'), 
                    createEntry('CONVENIO.COD-CONVENIO', '7849036'),

                    createEntry('PAGADOR.TP-DOC', '02'),
                    createEntry('PAGADOR.NUM-DOC', '66932165449'),
                    createEntry('PAGADOR.NOME', 'Romero Rolim Teste'),
                    createEntry('PAGADOR.ENDER', 'Rua Teste 1'),
                    createEntry('PAGADOR.BAIRRO', 'Centro'),
                    createEntry('PAGADOR.CIDADE', 'Recife'),
                    createEntry('PAGADOR.UF', 'PE'),
                    createEntry('PAGADOR.CEP', '50000000'),

                    createEntry('TITULO.NOSSO-NUMERO', '0000000000005'),
                    createEntry('TITULO.SEU-NUMERO', '000000000000005'),
                    createEntry('TITULO.DT-VENCTO', '23022017'),
                    createEntry('TITULO.DT-EMISSAO', '21022017'),
                    createEntry('TITULO.ESPECIE', '02'),
                    createEntry('TITULO.VL-NOMINAL', '000000000000015'),
                    createEntry('TITULO.PC-MULTA', '000'),
                    createEntry('TITULO.QT-DIAS-MULTA', '00'),
                    createEntry('TITULO.PC-JURO', '000'),
                    createEntry('TITULO.TP-DESC', '0'),
                    createEntry('TITULO.VL-DESC', '000'),
                    createEntry('TITULO.DT-LIMI-DESC', '00000000'),
                    createEntry('TITULO.VL-ABATIMENTO', '000'),
                    createEntry('TITULO.TP-PROTESTO', '0'),
                    createEntry('TITULO.QT-DIAS-PROTESTO', '00'),
                    createEntry('TITULO.QT-DIAS-BAIXA', '1'),  

                    createEntry('MENSAGEM', 'Sr. Caixa Nao receber apos vencimento nem valor menor que o do documento.')
                   );

    $ticketRequest = array('dados'     => $dados,
                           'expiracao' => 100,
                           'sistema'   => 'YMB');

    $toReturn = array('TicketRequest' => $ticketRequest);

    return $toReturn;
}

function getRegistroXml($ticket)
{
    $inclusaoTitulo = array('dtNsu'      => '21022017',
                            'estacao'    => 'SIOV',
                            'nsu'        => 'TST00000000000000005', 
                            'ticket'     => $ticket,
                            'tpAmbiente' => 'T'
                           );

    $toReturn = array('dto' => $inclusaoTitulo);

    return $toReturn;
}

function teste()
{

    try
    {

      $options = array('keep_alive' => false,
                      'trace'      => true,
                      'local_cert' => 'c:\temp\ymbdlbhml.pem', // substituir pelo caminho do certificado
                      'passphrase' => 'xxxxxx',   // substituir pela senha do certificado
                      'cache_ws'   => WSDL_CACHE_NONE
                      );          

        $cliTicket = new SoapClient("https://ymbdlb.santander.com.br/dl-ticket-services/TicketEndpointService/TicketEndpointService.wsdl", $options);
        echo ("CHAMANDO O DLB TICKET!!");                             
        // ticket

        $xmlCreate = getTicketXml();
        $cResponse = $cliTicket->create($xmlCreate); 

        // cobrança
        $cliCobranca = new SoapClient("https://ymbcash.santander.com.br/ymbsrv/CobrancaEndpointService/CobrancaEndpointService.wsdl", $options);
        $xmlRegistro = getRegistroXml($cResponse->TicketResponse->ticket);
        $rResponse   = $cliCobranca->registraTitulo($xmlRegistro);

        // Imprime no browser:
        print_r($xmlCreate);
        echo '<br><br>';
        print_r($xmlRegistro);
        echo '<br><br>';
        print_r($cResponse);
        echo '<br><br>';
        print_r($rResponse);
    }
    catch(SoapFault $e)
    {
        echo("EXCEÇÂO DO SOAP");
        var_dump($e);
    }
}

teste();
  
// Impresso no browser:
/*
Array ( [TicketRequest] => Array ( [dados] => Array ( [entry] => Array ( [entry1] => Array ( [key] => CONVENIO.COD-BANCO [value] => 0033 ) [entry2] => Array ( [key] => CONVENIO.COD-CONVENIO [value] => 7849036 ) [entry3] => Array ( [key] => PAGADOR.TP-DOC [value] => 02 ) [entry4] => Array ( [key] => PAGADOR.NUM-DOC [value] => 66932165449 ) [entry5] => Array ( [key] => PAGADOR.NOME [value] => Romero Rolim Teste ) [entry6] => Array ( [key] => PAGADOR.ENDER [value] => Rua Teste 1 ) [entry7] => Array ( [key] => PAGADOR.BAIRRO [value] => Centro ) [entry8] => Array ( [key] => PAGADOR.CIDADE [value] => Recife ) [entry9] => Array ( [key] => PAGADOR.UF [value] => PE ) [entry10] => Array ( [key] => PAGADOR.CEP [value] => 50000000 ) [entry11] => Array ( [key] => TITULO.NOSSO-NUMERO [value] => 0000000000005 ) [entry12] => Array ( [key] => TITULO.SEU-NUMERO [value] => 000000000000005 ) [entry13] => Array ( [key] => TITULO.DT-VENCTO [value] => 23022017 ) [entry14] => Array ( [key] => TITULO.DT-EMISSAO [value] => 21022017 ) [entry15] => Array ( [key] => TITULO.ESPECIE [value] => 02 ) [entry16] => Array ( [key] => TITULO.VL-NOMINAL [value] => 000000000000015 ) [entry17] => Array ( [key] => TITULO.PC-MULTA [value] => 000 ) [entry18] => Array ( [key] => TITULO.QT-DIAS-MULTA [value] => 00 ) [entry19] => Array ( [key] => TITULO.PC-JURO [value] => 000 ) [entry20] => Array ( [key] => TITULO.TP-DESC [value] => 0 ) [entry21] => Array ( [key] => TITULO.VL-DESC [value] => 000 ) [entry22] => Array ( [key] => TITULO.DT-LIMI-DESC [value] => 00000000 ) [entry23] => Array ( [key] => TITULO.VL-ABATIMENTO [value] => 000 ) [entry24] => Array ( [key] => TITULO.TP-PROTESTO [value] => 0 ) [entry25] => Array ( [key] => TITULO.QT-DIAS-PROTESTO [value] => 00 ) [entry26] => Array ( [key] => TITULO.QT-DIAS-BAIXA [value] => 1 ) [entry27] => Array ( [key] => MENSAGEM [value] => Sr. Caixa Nao receber apos vencimento nem valor menor que o do documento. ) ) ) [expiracao] => 100 [sistema] => YMB ) ) 

Array ( [dto] => Array ( [dtNsu] => 21022017 [estacao] => SIOV [nsu] => TST00000000000000005 [ticket] => /2K1e/KX+u2msniMOChH/BqRVL2ggwX41N/uFoUkRRsvCoU14y2bhCZYR1Vy+sjz/+3aA1ooGDRnLbOMGFgWdkUenrNs6QYmmCuwG2UQZYchzkdSt76wAH62ILGp9Kjk [tpAmbiente] => T ) ) 

stdClass Object ( [TicketResponse] => stdClass Object ( [retCode] => 0 [ticket] => /2K1e/KX+u2msniMOChH/BqRVL2ggwX41N/uFoUkRRsvCoU14y2bhCZYR1Vy+sjz/+3aA1ooGDRnLbOMGFgWdkUenrNs6QYmmCuwG2UQZYchzkdSt76wAH62ILGp9Kjk ) ) 

stdClass Object ( [return] => stdClass Object ( [codcede] => [convenio] => stdClass Object ( [codBanco] => 0000 [codConv] => 000000000 ) [descricaoErro] => @ERYKE0001 - NMPGD INVALIDO [dtNsu] => 21022017 [estacao] => SIOV [nsu] => TST00000000000000005 [pagador] => stdClass Object ( [bairro] => [cep] => 00000000 [cidade] => [ender] => [nome] => [numDoc] => 000000000000000 [tpDoc] => 00 [uf] => ) [situacao] => 20 [titulo] => stdClass Object ( [aceito] => [cdBarra] => [dtEmissao] => [dtEntr] => [dtLimiDesc] => [dtVencto] => [especie] => 00 [linDig] => [nossoNumero] => 0000000000000 [pcJuro] => 00000 [pcMulta] => 00000 [qtDiasBaixa] => 00 [qtDiasMulta] => 00 [qtDiasProtesto] => 00 [seuNumero] => [tpDesc] => 0 [tpProtesto] => 0 [vlAbatimento] => 000000000000000 [vlDesc] => 000000000000000 [vlNominal] => 000000000000000 ) [tpAmbiente] => T ) )
*/
