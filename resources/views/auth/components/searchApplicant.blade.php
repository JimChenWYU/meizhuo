<form action="{{ url('/auth/search') }}" method="post" class="padding-left-right-50px">
    {{ csrf_field() }}
    <md-input-container>
        <label>请输入学号或姓名</label>
        <md-input type="text" name="search" required></md-input>

        <md-button class="md-icon-button" type="submit">
            <md-icon>search</md-icon>
        </md-button>
    </md-input-container>
</form>