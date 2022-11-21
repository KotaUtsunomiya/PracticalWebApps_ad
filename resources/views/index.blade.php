<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Todo</title>
    <link rel="stylesheet" href="{{ asset('css/reset-stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @if (Auth::check())
    <div class="container">
        <div class="card">
            <div class="card__header">
                <p class="title">Todo List</p>
                <div class="auth">
                    <p class="user__info">「{{$user->name}}」でログイン中</p>
                    <form action="{{ route('logout') }}" id="logout" method="post">
                        @csrf
                        <button class="btn btn-logout">ログアウト</button>
                    </form>
                </div>
            </div>
            <a href="{{ route('todo.find') }}" class="btn btn-search">タスク検索</a>
            @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <dis class="todo">
                <form action="{{ route('todo.create') }}" method="post" class="flex">
                    @csrf
                    <input type="text" class="todo-add" name="text">
                    <select name="tag" id="" class="tag">
                        <option value="家事">家事</option>
                        <option value="勉強">勉強</option>
                        <option value="運動">運動</option>
                        <option value="食事">食事</option>
                        <option value="移動">移動</option>
                    </select>
                    <input type="submit" class="btn btn-add" value="追加">
                </form>
            </dis>
            <table>
                <thead>
                    <tr>
                        <th>作成日</th>
                        <th>タスク名</th>
                        <th>タグ</th>
                        <th>更新</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($todos)
                    @foreach($todos as $r)
                    <form method="post" action="?">
                        @csrf
                        <tr>
                            <td>{{ $r->created_at }}</td>
                            <td>
                                <input type="text" class="todo-content" value="{{ $r->text }}" name="text">
                            </td>
                            <td>
                                <select name="tag" class="tag">
                                    @php
                                        $tag = $r->tag;
                                    @endphp
                                    @if($tag == "家事")
                                        <option value="家事" selected>家事</option>
                                        <option value="勉強">勉強</option>
                                        <option value="運動">運動</option>
                                        <option value="食事">食事</option>
                                        <option value="移動">移動</option>
                                    @elseif($tag == "勉強")
                                        <option value="家事">家事</option>
                                        <option value="勉強" selected>勉強</option>
                                        <option value="運動">運動</option>
                                        <option value="食事">食事</option>
                                        <option value="移動">移動</option>
                                    @elseif($tag == "運動")
                                        <option value="家事">家事</option>
                                        <option value="勉強">勉強</option>
                                        <option value="運動" selected>運動</option>
                                        <option value="食事">食事</option>
                                        <option value="移動">移動</option>
                                    @elseif($tag == "食事")
                                        <option value="家事">家事</option>
                                        <option value="勉強">勉強</option>
                                        <option value="運動">運動</option>
                                        <option value="食事" selected>食事</option>
                                        <option value="移動">移動</option>
                                    @elseif($tag == "移動")
                                        <option value="家事">家事</option>
                                        <option value="勉強">勉強</option>
                                        <option value="運動">運動</option>
                                        <option value="食事">食事</option>
                                        <option value="移動" selected>移動</option>
                                    @endif
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="_method" value="post" class="btn btn-update" formaction="{{ route('todo.update', ['id'=>$r->id]) }}">更新</button>
                            </td>
                            <td>
                                <button type="submit" name="_method" value="delete" class="btn btn-delete" formaction="{{ route('todo.destroy', ['id'=>$r->id]) }}">削除</button>
                            </td>
                        </tr>
                    </form>
                    @endforeach
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
    @else
    <p>ログインしてください。（<a href="/login">ログイン</a>｜
    <a href="/register">登録</a>）</p>
    @endif
</body>
</html>