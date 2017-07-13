<?php return array (
  'appkey' => '23553734',
  'secretKey' => 'a63cd257c62bbe2adede8262af02ceb9',
  'signname' => '拣豆网',
  'smstemplate' => 
  array (
    'reg' => 
    array (
      'templatecode' => 'SMS_25030007',
      'templateeffect' => '用户注册（验证码）',
    ),
    'modifypd' => 
    array (
      'templatecode' => 'SMS_25030011',
      'templateeffect' => '找回密码（验证码）',
    ),
    'empinfo' => 
    array (
      'templatecode' => 'SMS_25030011',
      'templateeffect' => '雇主认证（短信验证码）',
    ),
    'engidentityphone' => 
    array (
      'templatecode' => 'SMS_25030011',
      'templateeffect' => '工程师手机认证（短信验证码）',
    ),
    'empidentityphone' => 
    array (
      'templatecode' => 'SMS_25030011',
      'templateeffect' => '雇主手机认证（短信验证码）',
    ),
    'bargain' => 
    array (
      'templatecode' => 'SMS_25610051',
      'templateeffect' => '雇主议价（短信通知）',
    ),
    'enginfo' => 
    array (
      'templatecode' => 'SMS_25030011',
      'templateeffect' => '工程师认证（短信验证码）',
    ),
    'starttask' => 
    array (
      'templatecode' => 'SMS_25595050',
      'templateeffect' => '费用已托管，开始工作',
    ),
    'newtaskrelease' => 
    array (
      'templatecode' => 'SMS_25645545',
      'templateeffect' => '新任务发布',
    ),
    'processfile' => 
    array (
      'templatecode' => 'SMS_61355068',
      'templateeffect' => '进度报告',
    ),
    'uploadupdate' => 
    array (
      'templatecode' => 'SMS_25605037',
      'templateeffect' => '技术文件或审图意见更新',
    ),
    'fine_file_examane_ok' => 
    array (
      'templatecode' => 'SMS_61785268',
      'templateeffect' => '工程师上传最终报告',
    ),
    'conductingtaskcance' => 
    array (
      'templatecode' => 'SMS_47405020',
      'templateeffect' => '雇主取消进行中的任务 ',
    ),
    'examinesucc' => 
    array (
      'templatecode' => 'SMS_66060082',
      'templateeffect' => '认证审核通过',
    ),
    'examineerror' => 
    array (
      'templatecode' => 'SMS_67155038',
      'templateeffect' => '认证审核失败',
    ),
    'orderover' => 
    array (
      'templatecode' => 'SMS_67100210',
      'templateeffect' => '招标即将结束',
    ),
    'voucher' => 
    array (
      'templatecode' => 'SMS_70530430',
      'templateeffect' => '充值成功',
    ),
    'offermoneycallback' => 
    array (
      'templatecode' => 'SMS_70490422',
      'templateeffect' => '保证金退回',
    ),
  ),
  'mailer' => 
  array (
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false,
    'transport' => 
    array (
      'class' => 'Swift_SmtpTransport',
      'host' => 'smtp.jeendon.com',
      'username' => 'sh001@jeendon.com',
      'password' => 'JIANdoush001',
      'port' => '25',
      'encryption' => 'tls',
    ),
    'messageConfig' => 
    array (
      'charset' => 'UTF-8',
      'from' => 
      array (
        'sh001@jeendon.com' => '拣豆网',
      ),
    ),
  ),
  'emailuser' => 
  array (
    'canceltask' => 
    array (
      'des' => '任务取消',
      'username' => 
      array (
        1 => 'jiandoukefu',
      ),
    ),
    'application_for_certification' => 
    array (
      'des' => '用户提交认证申请',
      'username' => 
      array (
        1 => 'jiandoukefu',
      ),
      'model' => '{$name}提交了认证申请，请尽快处理！',
    ),
    'no_upload_progress_report' => 
    array (
      'des' => '工程师未上传进度报告',
      'username' => 
      array (
      ),
      'model' => '{$name}未按时提交{$renwuhao}的进度报告，请尽快与工程师联系！',
    ),
    'upload_final_results' => 
    array (
      'des' => '工程师每次上传了最终成果',
      'username' => 
      array (
        2 => 'jiandoukefu',
      ),
      'model' => '{$name}上传了{$renwuhao}的最终成果，请尽快予以处理！',
    ),
    'apply_for_cancellation_of_ongoing_tasks' => 
    array (
      'des' => '雇主申请取消进行中的任务',
      'username' => 
      array (
        1 => 'jiandoukefu',
      ),
      'model' => '{$name}取消了{$renwuhao}任务，请尽快与雇主核实情况，并做进一步处理！',
    ),
    'the_employer_refund_deduction' => 
    array (
      'des' => '雇主申请退款/扣款',
      'username' => 
      array (
        1 => 'jiandoukefu',
      ),
      'model' => '{$name}对{$renwuhao}提出了退款/扣款申请，请尽快与雇主核实情况，并做进一步处理！',
    ),
    'engineer_application_eighty' => 
    array (
      'des' => '工程师申请80%款项',
      'username' => 
      array (
        1 => 'jiandoukefu',
      ),
      'model' => '{$name}申请{$renwuhao}任务80%的款费，请尽快予以审核处理！',
    ),
    'engineer_application_twenty' => 
    array (
      'des' => '工程师申请20%款项',
      'username' => 
      array (
        1 => 'jiandoukefu',
      ),
      'model' => '{$name}申请{$renwuhao}任务20%的款费，请尽快予以审核处理！',
    ),
    'withdrawals' => 
    array (
      'des' => '提现申请',
      'username' => 
      array (
        0 => 'jiandoukefu',
      ),
      'model' => '{$name}提交了提现申请，提现金额为{$jine}，请尽快予以审核处理！',
    ),
    'submit_work' => 
    array (
      'des' => '工程师提交作品审核',
      'username' => 
      array (
        1 => 'jiandoukefu',
      ),
      'model' => '{$name}提交了代表作品，请尽快予以审核处理！',
    ),
    'offer_order' => 
    array (
      'des' => '招标结束邮件提醒',
      'username' => 
      array (
        0 => 'jiandoukefu',
      ),
      'model' => '{dingdanhao}招标结束，请尽快处理投标保证金退回事宜！',
    ),
  ),
);?>