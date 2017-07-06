<?php
 
class ItemController extends Controller
{
    // 首页方法，测试框架自定义DB查询
    public function index()
    {   
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

        if ($keyword) {
            $items = (new ItemModel())->where('item_name', $keyword);
        } else {
            $items = (new ItemModel)->all();
        }   
        
        $title = '全部条目';
        $url = array(
            'index' => $this->url('item', 'index'),
            'manage' => $this->url('item','manage'),
            'del' =>  $this->url('item','delete')
            );
        $this->view('index',compact('title', 'items', 'url'));

    }
    
    // 添加记录，测试框架DB记录创建（Create）
    public function add()
    {
        $data['item_name'] = $_POST['value'];
        (new ItemModel)->add($data);

        $url = $this->url('item', 'index');
        $title = '创建成功';
        $this->view('add',compact('title', 'url'));
    }
    
    // 操作管理
    public function manage($id = 0)
    {   
        $item = array();
        $postUrl = $this->url('item','add');
        if ($id) {
            $item = (new ItemModel)->find($id);
            $postUrl = $this->url('item','update');
        }

        $title = '条目管理';
        $this->view('manage',compact('title',  'item', 'postUrl'));
    }
    
    // 更新记录，测试框架DB记录更新（Update）
    public function update()
    {
        $id = $_POST['id'];
        $updateData['item_name'] = $_POST['value'];
        $count = (new ItemModel)->update($updateData, $id);
        $url = $this->url('item', 'index');
        $title = '修改成功';
        $this->view('update',compact('title', 'count', 'url'));
    }
    
    // 删除记录，测试框架DB记录删除（Delete）
    public function delete($id = null)
    {  
        $count = (new ItemModel)->destroy($id);

        $url = $this->url('item', 'index');
        $title = '删除成功';
        $this->view('delete',compact('title', 'count', 'url'));
    }
}
