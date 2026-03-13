<button onclick="verifyMpinBeforeCopy(<?php echo $password_id; ?>)">Copy Password</button>

<script>
function verifyMpinBeforeCopy(passwordId) {
  const mpin = prompt("Enter your 4-digit mPIN:");
  if (mpin && mpin.length === 4) {
    fetch('verify_mpin.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `mpin=${mpin}&password_id=${passwordId}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        navigator.clipboard.writeText(data.password);
        alert("Password copied to clipboard.");
      } else {
        alert(data.message);
      }
    });
  } else {
    alert("Invalid mPIN format.");
  }
}
</script>
