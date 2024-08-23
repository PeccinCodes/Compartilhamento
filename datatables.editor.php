<?php
// Utiliza a biblioteca do DatatablesEditor 
session_start();
date_default_timezone_set('America/Sao_Paulo');

// DataTables PHP library
include("../../../editor/lib/DataTables.php");

// PHPMailer library
require '../../../vendor/autoload.php';

// Classes do Alias ​​Editor para que sejam fáceis de usar
use
    DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Mjoin,
    DataTables\Editor\Options,
    DataTables\Editor\Upload,
    DataTables\Editor\Validate,
    DataTables\Editor\ValidateOptions;

function logChange ($db, $action, $id, &$values) {
    $db->insert('PCN_SIG_QUALIDADE_FORN_LOG', array(
        'USUARIO'      => $_SESSION['usuarioAd'],
        'CRACHA'       => $_SESSION['cracha'],
        'DEPARTAMENTO' => $_SESSION['department'],
        'ACAO'         => $action,
        'VALOR'        => json_encode($values),
        'LINHA'        => $id,
        'DATA_ORACLE'  => date('d/m/y H:i:s')
    ));
}

$db->sql("BEGIN
  FND_CLIENT_INFO.SET_ORG_CONTEXT('103');
  DBMS_APPLICATION_INFO.SET_CLIENT_INFO('103');
  APPS.MO_GLOBAL.SET_POLICY_CONTEXT('S','103'); 
END;");

//Editor::inst($db, 'PCN_SIG_QUALIDADE_FORN_REG', 'ID')
Editor::inst($db, 'PCN_SIG_QUALIDADE_FORN_REG', 'ID')
    ->field(
        Field::inst('PCN_SIG_QUALIDADE_FORN_REG.ID_ITEM'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.ID'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.ID_REGISTRO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.COD_ITEM')
            ->options(Options::inst()
                ->table('PCN_VW_PO_FORNECEDORES_APROV')
                ->value('CODIGO')
                ->label(['CODIGO','DESCR'])
                ->render( function ( $row ) {
                    return $row['CODIGO'].' - ('.$row['DESCR'].')';
                } )
                ->where(function($q) {
                    $q->where('STATUS', 'New', '=');    
                })
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.AP')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_AP'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.FA')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_FA'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.FP')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_FP'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.ID')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_IN'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.FISPQ')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_FISPQ'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.CK')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_CK'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.CH')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_CH'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.AF')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_AF'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.TR')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_TR'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.LA')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_LA'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.LM')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_LM'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.VT')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_VT'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.LAN')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_LAN'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DGMO')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/item/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_DGMO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.OBS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.STATUS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_CADASTRO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_ITEM.DATA_ALTERACAO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_REG.ID_FAB'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.ID'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.CHAVE'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.ID_FAB')
            ->options(Options::inst()
                ->table('PCN_VW_PO_FORNECEDORES_APROV')
                ->value('ID_FORNECEDOR')
                ->label( ['CNPJ_FORNECEDOR', 'ID_FORNECEDOR', 'FORNECEDOR', 'DEPOSITO'] )
                ->render( function ( $row ) {
                    return $row['FORNECEDOR'].' - ' .$row['CNPJ_FORNECEDOR']. ' - ' .$row['DEPOSITO'];
                } )
                ->where(function($q) {
                    $q->where('TIPO', 'Fabricante', '=');    
                    $q->or_where('TIPO', 'Direto', '=');
                    $q->or_where('STATUS', 'New', '=');
            })
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.AP')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/fabricante/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_AP'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.CA')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/fabricante/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_CA'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.CK')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/fabricante/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_CK'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.CH')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/fabricante/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_CH'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.CF')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/fabricante/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_CF'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.TR')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/fabricante/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_TR'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.AF')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/fabricante/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_AF'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.OBS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.STATUS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_CADASTRO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_FAB.DATA_ALTERACAO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_REG.ID_DIS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.ID'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.CHAVE'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.ID_FORNECEDOR')
            ->options(Options::inst()
                ->table('PCN_VW_PO_FORNECEDORES_APROV')
                ->value('ID_FORNECEDOR')
                ->label(['CNPJ_FORNECEDOR','ID_FORNECEDOR','FORNECEDOR', 'DEPOSITO'])
                ->render( function ( $row ) {
                    return $row['FORNECEDOR'].' - ' .$row['CNPJ_FORNECEDOR']. ' - ' .$row['DEPOSITO'];
                } )
                ->where(function($q) {
                $q->or_where('TIPO', 'Distribuidor', '=');
                $q->or_where('STATUS', 'New', '=');
            })
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.AP')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/distribuidor/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.DATA_AP'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.RP')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/distribuidor/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.DATA_RP'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.AF')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/distribuidor/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
            ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.DATA_AF'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.ALF')
                ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/NewSIG/src/files/qualidade/homologacao/distribuidor/__ID__.__EXTN__' ) // MODIFICAR QUANDO FOR EFETUAR A SUBIDA PARA **PRODUÇÃO**
                ->db( 'PCN_SIG_QUALIDADE_FILE', 'ID', array(
                    'FILENAME'    => Upload::DB_FILE_NAME,
                    'FILESIZE'    => Upload::DB_FILE_SIZE,
                    'WEB_PATH'    => Upload::DB_WEB_PATH,
                    'SYSTEM_PATH' => Upload::DB_SYSTEM_PATH,
                    'EXTN'        => Upload::DB_EXTN
                ) )
                ->validator( Validate::fileSize( 25000000, 'Os arquivos devem ser menores que 20Mb' ) )
                ->validator( Validate::fileExtensions( array( 'pdf'), "Faça o upload do arquivo PDF." ) )
                ),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.DATA_ALF'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.OBS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.STATUS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.DATA_CADASTRO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_DIS.DATA_ALTERACAO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_REG.STATUS'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_REG.DATA_CADASTRO'),
        Field::inst('PCN_SIG_QUALIDADE_FORN_REG.DATA_ALTERACAO')
    )
    ->leftJoin( 'PCN_SIG_QUALIDADE_FORN_ITEM', 'PCN_SIG_QUALIDADE_FORN_ITEM.ID', '=', 'PCN_SIG_QUALIDADE_FORN_REG.ID_ITEM' )
    ->leftJoin( 'PCN_SIG_QUALIDADE_FORN_FAB', 'PCN_SIG_QUALIDADE_FORN_FAB.ID', '=', 'PCN_SIG_QUALIDADE_FORN_REG.ID_FAB', )
    ->leftJoin( 'PCN_SIG_QUALIDADE_FORN_DIS', 'PCN_SIG_QUALIDADE_FORN_DIS.ID', '=', 'PCN_SIG_QUALIDADE_FORN_REG.ID_DIS',  )
    ->leftJoin( 'PCN_VW_PO_FORNECEDORES_APROV', 'PCN_SIG_QUALIDADE_FORN_ITEM.COD_ITEM', '=', 'PCN_VW_PO_FORNECEDORES_APROV.CODIGO')
    ->leftJoin( 'PCN_VW_PO_FORNECEDORES_APROV as PCN_VW_PO_FORNECEDORES_APROV_FAB', 'PCN_SIG_QUALIDADE_FORN_FAB.ID_FAB', '=', 'PCN_VW_PO_FORNECEDORES_APROV_FAB.ID_FORNECEDOR')
    ->leftJoin( 'PCN_VW_PO_FORNECEDORES_APROV as PCN_VW_PO_FORNECEDORES_APROV_DIS', 'PCN_SIG_QUALIDADE_FORN_DIS.ID_FORNECEDOR', '=', 'PCN_VW_PO_FORNECEDORES_APROV_DIS.ID_FORNECEDOR')
    ->on('postCreate', function ($editor, $id, &$values, &$row) {
        logChange($editor->db(), 'create', $id, $values);
    })
    ->on('postEdit', function ($editor, $id, &$values, &$row) {
        logChange($editor->db(), 'edit', $id, $values);
    }) 
    ->on('postRemove', function ($editor, &$id, &$values) {
        logChange($editor->db(), 'delete', $id, $values);
    })
    ->debug(true)
    ->process($_POST)
    ->json();
