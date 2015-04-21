<?php
namespace ostashevdv\smsimple;

require "smsimple.class.php";

use \SMSimple as SMSbase;
use \SMSimpleException;

class SMSimple extends SMSbase implements \yii\base\Configurable
{
    public $session_id = '';
    public $username = '';
    public $password = '';
    public $encoding = 'UTF-8';
    public $xmlrpc = null;
    public $input_encoding = 'UTF-8';
    public $new_xmlrpc = 'auto';
    public $url = 'http://api.smsimple.ru';
    public $origin_id = null;

    public function __construct($config=[])
    {
        if (!empty($config)) {
           \Yii::configure($this, $config);
        }
        $GLOBALS['xmlrpc_internalencoding'] = $this->encoding;
        $GLOBALS['xmlrpc_defencoding'] = $this->encoding;
        $this->xmlrpc = new \xmlrpc_client($this->url);
        $this->xmlrpc->return_type = 'phpvals';
        $this->xmlrpc->request_charset_encoding = $this->encoding;
    }

    /**
     * Отправка одиночного сообщения
     *----------------------------------------------
     * @param:  $phone      string  телефонный номер абонента (любой формат с кодом-телефоном, например `'8-916-1234567'` или `'79161234567'`) или несколько через запятую (пробелы разрешены, например `'79031234567, 89161234567'`)
     * @param:  $message    string  текст SMS-сообщения
     * @param*:  $multiple   bool    необязательный параметр, по-умолчанию `false`. Если вы отправляете сообщение сразу нескольким адресатам, то им присвоистся один и тот же (`false`) или разные (`true`) номера.
     *
     * @returns: int Возвращает номер (`id`) сообщения, по которому потом можно получать статус доставки/недоставки. Для `$multiple = false` вернёт одно число, для `$multiple = true` -- массив номеров в той последовательности, в которой шли телефоны абонентов.
     */
    public function send($phone, $message, $multiple = false, $origin_id=null)
    {
        if ( ($origin_id = $origin_id ? : $this->origin_id)===null ) {
            throw new SMSimpleException('$origin_id is not configured.');
        }
        return parent::send($origin_id, $phone, $message, $message);
    }
}