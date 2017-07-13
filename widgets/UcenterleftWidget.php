<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/3
 * Time: 9:38
 */
use Yii;
use  yii\bootstrap\Widget;
class UcenterleftWidget extends Widget{
    public $type; //类型 emp：雇主 eng：工程师
    public $item = []; //左边列表列表
    public function init()
    {
        $this->item = [
            '2' => [

                [
                    '需求发布',
                    [
                        [
                            'value' => '我要发布需求',
                            'url' => '/emp-demand-release/demand-select-type',
                        ],
                        [
                            'value' => '发布中的订单',
                            'url' => '/emp-order-manage/emp-releaseing-order-list',
                        ],
                    ]
                ],

                [
                    '交易管理',
                    [
                        [
                            'value' => '招标中的订单',
                            'url' => '/emp-order-manage/emp-bidding-order-list',
                        ],
                        [
                            'value' => '待托管费用的订单',
                            'url' => '/emp-order-manage/emp-paying-order-list',
                        ],
                        [
                            'value' => '进行中的订单',
                            'url' => '/emp-order-manage/emp-conducting-order-list',
                        ],
                        [
                            'value' => '已完成的订单',
                            'url' => '/emp-order-manage/emp-successing-order-list',
                        ],
                        [
                            'value' => '订单回收站',
                            'url' => '/emp-order-manage/emp-canceling-order-list',
                        ],

                    ]
                ],
                [
                    '账户管理',
                    [
                        [
                            'value' => '账户设置',
                            'url' => '/emp-account-manage/emp-info',
                        ],
                        [
                            'value' => '账户安全',
                            'url' => '/emp-account-manage/emp-account-security',
                        ],

                        [
                            'value' => '我的资金账号',
                            'url' => '/emp-my-wallet/emp-my-wallet-index',
                        ],
                    ]
                ],
            ],
            '1' => [
                [
                    '任务管理',
                    [
                        [
                            'value' => '待缴纳投标保证金任务',
                            'url' => '/task-hall/offer-order-pay-list',
                        ],
                        [
                            'value' => '参与竞标的任务',
                            'url' => '/eng-order-manage/eng-bidding-order-list',
                        ],
                        [
                            'value' => '进行中的任务',
                            'url' => '/eng-order-manage/eng-conducting-order-list',
                        ],
                        [
                            'value' => '已完成的任务',
                            'url' => '/eng-order-manage/eng-successing-order-list',
                        ]
                    ]
                ],
                [
                    '我的账户',
                    [
                        [
                            'value' => '账户设置',
                            'url' => '/eng-account-manage/eng-info',
                        ],
                        [
                            'value' => '账户安全',
                            'url' => '/eng-account-manage/eng-account-security',
                        ],
                        [
                            'value' => '我的钱包',
                            'url' => '/eng-my-wallet/eng-my-wallet-index',
                        ]
                    ]
                ],
                [
                    '主页管理',
                    [
                        [
                            'value' => '个人主页',
                            'url' => '/eng-home/eng-home-detail.html?eng_id='.yii::$app->engineer->id,
                        ],
                        [
                            'value' => '上传作品',
                            'url' => '/eng-home-manage/eng-home-manage-upload-work',
                        ],
                        [
                            'value' => '作品管理',
                            'url' => '/eng-home-manage/eng-home-manage-manage-work',
                        ]
                    ]
                ],
            ]
        ];
    }

    public function run()
    {
        $items = $this->item[$this->type];
        return $this->render('/layouts/uleft',[
            'items' => $items
        ]);
    }


}