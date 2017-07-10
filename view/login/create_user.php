<div class="container">

    <form action="handle_new_user" method="POST">
        <table>
            <h1>Skapa användare</h1>
            <tr>
                <td>Namn:</td><td><input type="text" name="new_name"></td>
            </tr>
            <tr>
                <td>Välj lösenord:</td><td><input type="password" name="new_pass"></td>
            </tr>
            <tr>
                <td>Skriv in lösenord på nytt:</td><td><input type="password" name="re_pass"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submitCreateForm" value="Skapa"></td>
            </tr>
        </table>
    </form>
    <p><a href='login'>Tillbaka till login</a></p>
