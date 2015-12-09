<?php
/**
 *依次以母串的每一个字符为中心轴 得到回文串
 *比较得到的回文串的长度
 *@param  $strName  -String  要输入的字符串
 *@return $longest  -Int     最长回串的长度
 */
function LongestPalindromicSubString($strName)
{
    if(empty($strName))//如果是空串 返回空引用
    {
        return null;
    }
    $strLength = strlen($strName);
    if($strLength == 1) //如果该字符串只有一个字符
    {
        return 1;
    }

    $longest = 1;//初始最长的回文串的长度为1
    for($i = 0;$i < $strLength; $i++)
    {
        if(isPalindrome($strName, $i) > $longest)
        {
            $longest = isPalindrome($strName, $i);
        }
    }
    return $longest;
}

/**
 *判断给定中心轴的字符串是否是回文串 如果是 返回相应的长度
 *
 *@param     $strName  -String  要判断的字符串
 *@return              -Int     回文串的长度
 */
function isPalindrome($strName,$mid)
{
    $strLength = strlen($strName);
    $left      = $mid - 1;
    $right     = $mid + 1;
    while($strName[$mid] == $strName[$right])//先比较该下标字符是否与它下一个字符相同
    {
        $right++;
    }
    while($left >= 0 && $right < $strLength && $strName[$left] == $strName[$right])
    {
        $left--;
        $right++;
    }
    
    
    return $right - $left -1;
}
$strName = "abba";
echo LongestPalindromicSubString($strName);


